# Compatibility with the rewritten webtrees Core privacy policy

This document records the compatibility work associated with
[`hh_legal_notice` issue #147](https://github.com/hartenthaler/hh_legal_notice/issues/147)
and the preliminary webtrees Core change in commit
[`4e6ccdb0`](https://github.com/fisharebest/webtrees/commit/4e6ccdb0a9ff794cb0e9c032b219944d0da2d2de).

## Work completed against the currently released webtrees version

`LegalNoticeFooterModule` now declares its own protected
`analyticsModules(Tree $tree, UserInterface $user): Collection` method. The
module's privacy-policy page therefore no longer depends on the visibility of
the method with the same name in the Core `PrivacyPolicy` class. The
implementation continues to use the public `ModuleService` API and returns only
enabled analytics modules that identify themselves as trackers, matching the
current Core behaviour.

The inherited calls used by the module were reviewed:

- `getPageAction()` is implemented by `hh_legal_notice` and calls the new
  module-owned analytics lookup.
- `getFooter()` remains inherited. In the currently released Core it can call
  the protected override; in the preliminary rewritten Core it uses its own
  private helper internally.
- The current Core constructor requires `ModuleService` and `UserService`. The
  preliminary rewritten constructor requires only `ModuleService`. The module
  continues to initialise the currently released signature and does not assume
  that the preliminary signature has already been published. PHP accepts the
  additional `UserService` argument for the preliminary user-defined
  constructor, while the first argument remains the required `ModuleService`.

## Required checks after the next webtrees release

The referenced Core commit is not a released compatibility contract. After the
next webtrees version is published, test against that release and review the
final constructor and method signatures again. Runtime checks must cover:

- the public privacy-policy page;
- the footer link and inherited footer output;
- the module settings page;
- analytics detection with and without active tracker modules; and
- operation with the Core privacy-policy module enabled and disabled.

Issue #147 should remain open until these checks have been completed against
the released version.
