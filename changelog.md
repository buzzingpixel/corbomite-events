# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.1.0] - 2019-04-06
### Added
- Added EventDispatcherInterface to the DI definitions
- Added EventListenerRegistrationInterface to the DI Definitions
### Changed
- Updated use of Corbomite DI deprecated methods and use the ContainerInterface wherever possible

## [2.0.0] - 2019-02-25
### Changed
- Removed redundant arguments from EventDispatcher::dispatch
- Added 100% code coverage PHPUnit testing

## [1.0.1] - 2019-01-21
### Fixed
- Fixed a bug with the collector not collecting events

## [1.0.0] - 2019-01-18
### New
- Initial Release
