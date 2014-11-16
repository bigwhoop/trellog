# trellog

![slideshow](/slideshow.gif?raw=true)

[![Build Status](https://travis-ci.org/bigwhoop/trellog.svg?branch=master)](https://travis-ci.org/bigwhoop/trellog)
[![Code Coverage](https://scrutinizer-ci.com/g/bigwhoop/trellog/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bigwhoop/trellog/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bigwhoop/trellog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bigwhoop/trellog/?branch=master)

Generate [CHANGELOG](http://keepachangelog.com/) files based on Trello lists.

## Installation

    composer require "bigwhoop/trellog":"~1.0"
    vendor\bin\trellog init

![init command presentation](/slideshow_init.gif?raw=true)

## Usage

    vendor\bin\trellog generate
    vendor\bin\trellog generate > CHANGELOG.md

![generate command presentation](/slideshow_generate.gif?raw=true)

## Config file

By default `trellog` will create config file named `.trellog.yml` in the current working directory. You can use the
`-c`/`--config` option if your file has a different name or location.

**Attention: This conig file will containt your trello API key and read-only access token.**

### Printer options

You can use the printer options in the config file to customize the generated output.

    printer:
      options:
        title: The title of the change log
        intro: A text displayed beneath the title. Can be as long as you want it to be.
        versions_whitelist:   # ignore Trello cards not titled ...
          - 1.1.0
          - 1.0.0
        versions_blacklist:   # ignore Trello cards titled ...
          - 2.0.0
        sections_whitelist:   # ignore card checklists not named ...
          - Added
          - Removed
        sections_blacklist:   # ignore card checklists named ...
          - Merges
          - Tests
        print_empty_sections: false   # if true, empty checklists are printed as well
        empty_section_template: Text to output if print_empty_sections is true and a section is empty


## License

MIT. See LICENSE file.