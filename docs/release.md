# Release checklist

Before publishing a new release:

1. Review all merged PRs since the previous release and derive user-oriented release notes from the changelog. Mention user-visible features, fixes, compatibility changes, and completed issues; omit documentation-only, translation-only, and internal maintenance changes unless they affect users.
2. Update `CUSTOM_VERSION` in `LegalNoticeFooterModule.php`.
3. Update `CUSTOM_RELEASE_DATE` in `LegalNoticeFooterModule.php`.
4. Update `latest-version.txt`.
5. Add a release-notes file under `docs/` and update the README version and “What’s new” section when needed.
6. Check all `.po` and `.mo` files for obvious translation or formatting errors.
7. Run the relevant syntax and translation checks.
8. Commit the release changes, create a PR, and merge it into `main`.
9. Run `New-WebtreesModuleRelease.ps1` against the clean merged checkout. Publish both the ZIP archive and its `.sha256` checksum as release assets so GitHub can count downloads.
10. Verify the published tag, release notes, assets, and `latest-version.txt` after publishing.
