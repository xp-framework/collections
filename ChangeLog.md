Collections change log
======================

## ?.?.? / ????-??-??

## 10.1.0 / 2024-03-24

* Made compatible with XP 12 - @thekid
* Added PHP 8.4 to the test matrix - @thekid
* Merged PR #4: Migrate to new testing library - @thekid

## 10.0.2 / 2021-10-21

* Made compatible with XP 11 - @thekid

## 10.0.1 / 2021-09-06

* Fixed PHP 8.1 compatibility for `Traversable` subtypes - @thekid

## 10.0.0 / 2020-10-04

* **Heads up: Requires XP 10.2 minimum!** - @thekid
* Convert annotations to PHP 8 attributes - @thekid

## 9.0.0 / 2020-04-10

* Implemented xp-framework/rfc#334: Drop PHP 5.6:
  . **Heads up:** Minimum required PHP version now is PHP 7.0.0
  . Rewrote code base, grouping use statements
  . Converted `newinstance` to anonymous classes
  (@thekid)

## 8.0.2 / 2020-04-09

* Implemented RFC #335: Remove deprecated key/value pair annotation syntax
  (@thekid)

## 8.0.1 / 2019-12-01

* Made compatible with XP 10 - @thekid

## 8.0.0 / 2017-05-28

* Removed deprecated `util.collections.Arrays` class - @thekid
* Removed deprecated `HashProvider` and implementations - @thekid
* Merged PR #2: Forward compatibility with XP 9.0.0 - @thekid

## 7.3.0 / 2017-04-23

* Simplified code: Replaced anonymous iterator instances with `yield`
  (@thekid)
* Merged PR #1: Remove HashProvider and deprecate it.
  This speeds up HashTable, HashSet, Queue and Stack performance by a
  factor between 2 and 4, depending on the usecase.
  (@thekid)

## 7.2.0 / 2016-08-28

* Added forward compatibility with XP 8.0.0 by ensuring `hashCode()` 
  always returns a string
  (@thekid)

## 7.1.0 / 2016-07-24

* Dropped official support for PHP 5.5 - code will still work but is no
  longer tested on Travis CI. This keeps XP6 compatibility.
  (@thekid)

## 7.0.0 / 2016-02-21

* **Adopted semantic versioning. See xp-framework/rfc#300** - @thekid 
* Added version compatibility with XP 7 - @thekid
* Deprecated util.collections.Arrays class as it relies on lang.types, which
  has been removed in XP7. For the utility methods it provides, check the
  [xp-forge/sequence](https://github.com/xp-forge/sequence) library.
  (@thekid)

## 6.5.6 / 2015-11-08

* **Heads up: Split library from xp-framework/core as per xp-framework/rfc#298**
  (@thekid)
