#!/bin/sh

PHPCS=./vendor/bin/phpcs

if [ -f "$PHPCS" ]; then
  $PHPCS --config-set installed_paths ../../../vendor/drupal/coder/coder_sniffer
fi
