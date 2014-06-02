Parallelbug
==========

Parallebug solves the once major issue when dealing with debugging in either the console or in the browser (for backend code) - It dumps the data you want to see in a file for viewing in a separate tab so that it does not interupt the current page.

The great thing about this is that it currently dumps the content in JSON format, which with the use of browsers extensions such as JSON View (https://chrome.google.com/webstore/detail/jsonview/chklaanhfefbnpoihckbnefhakgolnmc) allow the developer to easily see a variables current value.

# Requirements
**All**
* Read/Write permission for a folder

**PHP**
* version 5.5 (not tested in lower)
* JSON encode / decode (if using JSON formatting)

**Python**
* Support for 2.7 or 3.x (< 2.7 not tested)

# Usage
```
Parallelbug::$dir = __DIR__ . DIRECTORY_SEPARATOR . 'logs';

Parallelbug::dump(array(
	'blah'
), array(
	'filename' => 'array'
));
```

This will create a JSON file called `array.json` inside a directory called `logs` in the same folder as this script.
The JSON file will contain ouput of the first parameter.

```
{
  "__meta__":{
    "length":1,
    "type":"array",
    "timestamp":1401704939,
    "timestamp_pretty":"2014-06-02 12:28:59"
  },
  "dump":[
    "blah"
  ]
}
```
Parallelbug also has Python 2/3 support:

```
from xxx.Parallelbug import Parallelbug
import os

Parallelbug.dir = os.path.join(os.getcwd(), "logs")

Parallelbug.dump([
	"foo"
], {
	"filename": "array"
})
```

## Options
All of the default parameters can be overridden with the 2nd argument. Or if you find yourself using the same options over and over again you can ovverride the default options:

```
Parellebug::$settings['meta'] = false;
```

All of the options are:

```
public static $settings = array(
	//'filename' => uniqid(),
	'format' => 'json',
	'meta' => true,
	'meta_key' => '__meta__',
	'date_format' => 'Y-m-d H:i:s',
	'append' => false,
	'data_key' => 'dump',
	'append_group_key' => '__append_group__'
);
```

### Filename
As you can see the filename (when not provided) is automatically generated via a unique id. The unique key will change per language, aka PHP uses `uniqid()` and python uses `uuid4()`.

If the file already exists and `append` is `false` then the file will be overwritten.

### Format
Only JSON is supported at this moment, but other formats might be added.

### Meta
Whether to add meta information:
True =>
```
{
  "__meta__":{
    "length":1,
    "type":"array",
    "timestamp":1401704939,
    "timestamp_pretty":"2014-06-02 12:28:59"
  },
  "dump":[
    "blah"
  ]
}
```
False =>
```
[
  "blah"
]
```

### Meta Key, Data Key, Append Group Key
These options just change the keys to use for the JSON file.

### Date Format
The date format stirng to use to format the timestamp.

### Append
When `append = true` the JSON file has appended onto it the next set of data. However, to keep it parsable by JSON the old data and the new data is encapsulated in an array:

```
[
  "__append_group__",
  {
    "__meta__":{
      "length":1,
      "type":"array",
      "timestamp":1401710279,
      "timestamp_pretty":"2014-06-02 13:57:59"
    },
    "dump":{
      "foo":"blah"
    }
  },
  {
    "__meta__":{
      "length":1,
      "type":"array",
      "timestamp":1401710279,
      "timestamp_pretty":"2014-06-02 13:57:59"
    },
    "dump":{
      "foo":"blah"
    }
  },
  {
    "__meta__":{
      "length":1,
      "type":"array",
      "timestamp":1401710279,
      "timestamp_pretty":"2014-06-02 13:57:59"
    },
    "dump":{
      "foo2":"blah2"
    }
  }
]
```
