# Compatibility with the webtrees Core privacy policy

This document records the compatibility work associated with
[`hh_legal_notice` issues #147 and #148](https://github.com/hartenthaler/hh_legal_notice/issues/148)
and the webtrees Core privacy-policy changes introduced during the 2.3
development cycle.

## Work completed against the currently released webtrees version

`LegalNoticeFooterModule` now extends the stable Core `AbstractModule` and
declares its own protected
`analyticsModules(Tree $tree, UserInterface $user): Collection` method. The
module's privacy-policy page and footer therefore no longer depend on the
concrete Core `PrivacyPolicy` class or any of its private/protected
implementation details. The implementation continues to use the public
`ModuleService` API and returns only enabled analytics modules that identify
themselves as trackers, matching the current Core behaviour.

The module-owned entry points were reviewed:

- `getPageAction()` is implemented by `hh_legal_notice` and calls the new
  module-owned analytics lookup.
- `getFooter()` and `getPageAction()` are implemented by the module itself.
- The module resolves `ModuleService` and `UserService` from the Core service
  container, so it remains compatible with both supported Core constructor
  layouts without calling a `PrivacyPolicy` constructor.

## Required checks after the next webtrees release

Runtime checks must cover both supported webtrees versions. They should cover:

- the public privacy-policy page;
- the footer link and footer output;
- the module settings page;
- analytics detection with and without active tracker modules; and
- operation with the Core privacy-policy module enabled and disabled; and
- the absence of accidental duplicate privacy-policy or footer output.

Issue #148 can be closed once these checks have been completed against the
released versions.
