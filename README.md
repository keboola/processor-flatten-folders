# processor-flatten-folders

[![Build Status](https://travis-ci.org/keboola/processor-flatten-folders.svg?branch=master)](https://travis-ci.org/keboola/processor-flatten-folders)

Takes all folders in `/data/in/files`, `/data/in/tables` and flattens the subfolder structure.
Manifest files are ignored (and not copied).

Processor offers multiple flatten strategies:

**Concat Flatten strategy (concat)**

This is a default strategy. `/` character in the path will be replaced with a `-` character, eg `folder1/file1.csv => folder1-file1.csv`. 
Existing `-` characters will be escaped with an extra `-` character to resolve possible collisions, eg. `collision-file.csv => collision--file.csv`. 

There is a limitation of maximum flattened file name length `255` characters.

**Hash Flatten strategy (hash-sha256)**

Flattened file names are `sha256` hashes of files path.

   
# Usage

The processor supports these optional parameters:

 - `starting_depth` -- nesting level where the flattening starts, allowed values `0`, `1`, default `0`.
 - `flatten_strategy` -- strategy used for flattened files naming, allowed values `concat`, `hash-sha256`, default `concat`.
## Examples

### Starting Depth 0

```
{
    "definition": {
        "component": "keboola.processor-flatten-folders"
    },
    "parameters": {
        "starting_depth": 0
    }
}

```

Structure of the `in` folder:

```
/data/in/files/subfolder1/file1
/data/in/files/subfolder1/subfolder2/file2
```

Result

```
/data/in/files/subfolder1-file1
/data/in/files/subfolder1-subfolder2-file2
```

### Starting Depth 1


```
{
    "definition": {
        "component": "keboola.processor-flatten-folders"
    },
    "parameters": {
        "starting_depth": 1
    }
}

```

Structure of the `in` folder:

```
/data/in/files/subfolder1/file1
/data/in/files/subfolder1/subfolder2/file2
```

Result

```
/data/in/files/subfolder1/file1
/data/in/files/subfolder1/subfolder2-file2
```

### Filename conflicts

```
{
    "definition": {
        "component": "keboola.processor-flatten-folders"
    },
    "parameters": {
        "starting_depth": 0
    }
}

```

Structure of the `in` folder:

```
/data/in/files/subfolder/conflict/file1
/data/in/files/subfolder/conflict-file1
```

Result

```
/data/in/files/subfolder-conflict-file1
/data/in/files/subfolder-conflict--file1
```

## Development
 
Clone this repository and init the workspace with following command:

```
git clone https://github.com/keboola/processor-flatten-folders
cd processor-flatten-folders
docker-compose build
docker-compose run --rm dev composer install --no-scripts
```

Run the test suite using this command:

```
docker-compose run --rm dev composer tests
```
 
# Integration
 - Build is started after push on [Travis CI](https://travis-ci.org/keboola/processor-flatten-folders)
 - [Build steps](https://github.com/keboola/processor-flatten-folders/blob/master/.travis.yml)
   - build image
   - execute tests against new image
   - publish image to ECR if release is tagged
