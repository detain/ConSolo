<?php
/**
 * Trakt.TV Intgegration Updater
 *
 * - Trakt API Docs
 *   - https://trakt.docs.apiary.io/
 * - Trakt Related PHP Projects
 *   - https://github.com/owenvoke/trakt-to-yts
 *   - https://github.com/Shobba/plex-webhook-trakt-php
 *   - https://github.com/megawubs/trakt-api-wrapper
 *   - https://github.com/alanly/traktor
 */


require_once __DIR__.'/../../../bootstrap.php';

global $config;
$apiKey = $config['trakt']['api_key'];
$apiSecret = $config['trakt']['api_secret'];
