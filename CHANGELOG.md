# Change Log

## Unreleased
- Remove ugly windows console error (#20 from MarouaneRag/patch-1)
 
## [v2.5.0](https://github.com/bvanhoekelen/performance/tree/v2.5.0) - 2019-03-31
## Change
- Use `protected` instead of `private`
- Use `static` instead of `self`
- use `/**` for comments
- use `throw new exception` instead of `die`
- Require php version 5.6 and higher

## [v2.4.0](https://github.com/bvanhoekelen/performance/tree/v2.4.0) - 2018-12-11
### Add
 - Config item `Config::setClearScreen()` to prevent cleaning screen
 
## [v2.3.6](https://github.com/bvanhoekelen/performance/tree/v2.3.6) - 2018-10-05
### Fix
 - Add `overflow: auto` to result box

## [v2.3.5](https://github.com/bvanhoekelen/performance/tree/v2.3.5) - 2018-03-01
### Add
- SQL query log for web presenter 
### Change
- Max screen width to 140
 ### Fix
 - Wrong time rounding by SQL query log

## [v2.3.4](https://github.com/bvanhoekelen/performance/tree/v2.3.4) - 2018-02-08
### Remove
- Remove default time zone UTC. This has to be set by the user in php.ini
### Change
- Fix example 8, change dump of print_r

## [v2.3.2](https://github.com/bvanhoekelen/performance/tree/v2.3.2) - 2017-11-20
### Change
- Change error messages.
- dd() and dump() to die and print_r

### Remove
- Larapack/dd dependency. See https://github.com/bvanhoekelen/performance/issues/7

### Special thanks to
- https://github.com/vesper8 feedback on Larapack/dd dependency

## [v2.3.1](https://github.com/bvanhoekelen/performance/tree/v2.3.1) - 2017-09-14
### Change
- Increase accuracy for time measurement on normal points.
### Added
- Multiple point support, see wiki or issue https://github.com/bvanhoekelen/performance/issues/5

## [v2.2.1](https://github.com/bvanhoekelen/performance/tree/v2.2.1) - 2017-08-17
### Change
- Performance installation package uses less storage space.
- Add .gitattributes for ignore export the folder (assets, examples and screenshots).

## [v2.2.0](https://github.com/bvanhoekelen/performance/tree/v2.2.0) - 2017-07-17
### Added
- In the web interface can be hidden and the preference is store.

## [v2.1.0](https://github.com/bvanhoekelen/performance/tree/v2.1.0) - 2017-06-28
### Added
- Run user and process id information.

## [v2.0.2](https://github.com/bvanhoekelen/performance/tree/v2.0.2) - 2017-05-18
### Bug fix
- Fix Too few arguments to function error. See: https://github.com/illuminate/database/commit/ba465fbda006d70265362012653b4e97667c867b#diff-eba180ff89e23df156c82c995be952df

## [v2.0.1](https://github.com/bvanhoekelen/performance/tree/v2.0.1) - 2017-04-27
### Change
- Small fixes, typos and screenshots

## [v2.0.0](https://github.com/bvanhoekelen/performance/tree/v2.0.0) - 2017-04-26

### Added
- Add query log support
- Export function (included to file)
- Message function
- Enable an disable manual or automatic base on ENV:APP_DEBUG
- Config item Nice label

### Change
- Change config system
- Change display to presenter
- Big code refactoring

## [v1.0.7](https://github.com/bvanhoekelen/performance/tree/v1.0.7) - 2017-04-20
### Change
- Terminal view: redesign, add tool name and change background color

## [v1.0.6](https://github.com/bvanhoekelen/performance/tree/v1.0.6) - 2017-04-17
### Added
- Config item: ENABLE_TOOL see wiki for info

## [v1.0.5](https://github.com/bvanhoekelen/performance/tree/v1.0.5) - 2017-04-17
### Added
- Config item: POINT_LABEL_LTRIM see wiki for info
- Config item: POINT_LABEL_RTRIM see wiki for info

## [v1.0.4](https://github.com/bvanhoekelen/performance/tree/v1.0.4) - 2017-04-17
### Changes
- Imported typo Fixe form nunomaduro. Thanks!

## [v1.0.3](https://github.com/bvanhoekelen/performance/tree/v1.0.3) - 2017-04-16
### Added
- Config system
- Config item: CONSOLE_LIVE see wiki for info

### Changes
- Text by 'max execution time' by 0 to unlimited

### Remove
- Performance ascii art. Pull request form nunomaduro.

## [v1.0.2](https://github.com/bvanhoekelen/performance/tree/v1.0.2) - 2017-03-23
### Fixed
- Format to seconds
- Count task

## [v1.0.1](https://github.com/bvanhoekelen/performance/tree/v1.0.1) - 2017-03-23
### Fixed
- Missing </div> tag by web view
### Added
- Default font-family: Times;
- Phpunit test
- Travis.yml

## [v1.0.0](https://github.com/bvanhoekelen/performance/tree/v1.0.0) - 2017-03-22
- Start project on Packagist
