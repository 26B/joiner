# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Changed

- Resolve development dependencies independently in each PHP CI matrix job; do not commit `composer.lock`.

### Fixed

- Enable Zend assertions in CI so Pest can generate its PHPUnit configuration.

## [1.0.0] - 2026-10-03

### Added

- Add `Joiner\join()` for joining conditional strings with a configurable separator, recursively nested lists, and associative array maps.
- Add `Joiner\classnames()` as a space-joining wrapper that warns about invalid CSS identifiers.
- Include integer values and support `stdClass` condition maps in `Joiner\join()`.
- Convert objects implementing `__toString()` to strings in `Joiner\join()`.
- Require PHP 8.3 or later.
