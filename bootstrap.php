<?php
/**
 * Modify collection result to include null on collection lookup and save
 */

$this->on('collections.find.after', function ($name, &$entries) {
    if ($collection = include(cockpit()->path("#storage:collections/{$name}.collection.php"))) {
        foreach ($entries as $k => $v) {
            handleEntry($entries[$k], $collection['fields']);
        }
    }
});

$this->on('collections.save.after', function ($name, &$entry) {
    if ($collection = include(cockpit()->path("#storage:collections/{$name}.collection.php"))) {
        handleEntry($entry, $collection['fields']);
    }
});

function handleEntry(&$collectionEntry, $collectionFields) {
    foreach ($collectionFields as $field) {
        switch ($field['type']) {
            case 'string':
            case 'text':
                $isNonEmptyString = is_string($collectionEntry[$field['name']]) && strlen(trim($collectionEntry[$field['name']])) !== 0;
                $collectionEntry[$field['name']] = $isNonEmptyString ? $collectionEntry[$field['name']] : null;
                break;
            case 'boolean':
                $collectionEntry[$field['name']] = is_bool($collectionEntry[$field['name']]) ? $collectionEntry[$field['name']] : false;
                break;
            case 'number':
                $collectionEntry[$field['name']] = is_numeric($collectionEntry[$field['name']]) ? $collectionEntry[$field['name']] : 0;
                break;
            default:
                $collectionEntry[$field['name']] = !empty($collectionEntry[$field['name']]) ? $collectionEntry[$field['name']] : null;
                break;
        }
    }
}
