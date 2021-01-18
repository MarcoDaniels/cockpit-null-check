# Cockpit CMS Addon Null Check

This addon transforms the API response to include `null` value when a non-required field is empty.

## Install

```
cd path/to/cockpit/addons

git clone https://github.com/MarcoDaniels/cockpit-null-check.git
```

Download and unzip or clone this project to the addons folder, 
and the API will return `null` for the fields with no content on them.
