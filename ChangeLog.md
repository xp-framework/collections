Collections change log
======================

## ?.?.? / ????-??-??

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
