      $result[] = PHP_EOL;
      $result[] = PHP_EOL;
      $result[] = '--- '.$old_path.PHP_EOL;
      $result[] = '+++ '.$cur_path.PHP_EOL;
    $diff = implode('', $result);
    $binary_sources = array();
    foreach ($changes as $change) {
      if (!$this->isGitBinaryChange($change)) {
        continue;
      }

      $type = $change->getType();
      if ($type == ArcanistDiffChangeType::TYPE_MOVE_AWAY ||
          $type == ArcanistDiffChangeType::TYPE_COPY_AWAY ||
          $type == ArcanistDiffChangeType::TYPE_MULTICOPY) {
        foreach ($change->getAwayPaths() as $path) {
          $binary_sources[$path] = $change;
        }
      }
    }

      // changes, so find one of them arbitrarily and turn it into a MOVE_HERE.
      $is_binary = $this->isGitBinaryChange($change);
        $old_binary = idx($binary_sources, $this->getCurrentPath($change));
        $change_body = $this->buildBinaryChange($change, $old_binary);
      $result[] = "diff --git {$old_index} {$cur_index}".PHP_EOL;
        $result[] = "new file mode {$new_mode}".PHP_EOL;
          $type == ArcanistDiffChangeType::TYPE_COPY_AWAY ||
          $type == ArcanistDiffChangeType::TYPE_CHANGE) {
          $result[] = "old mode {$old_mode}".PHP_EOL;
          $result[] = "new mode {$new_mode}".PHP_EOL;
        $result[] = "copy from {$old_path}".PHP_EOL;
        $result[] = "copy to {$cur_path}".PHP_EOL;
        $result[] = "rename from {$old_path}".PHP_EOL;
        $result[] = "rename to {$cur_path}".PHP_EOL;
          $result[] = "deleted file mode {$old_mode}".PHP_EOL;
          $result[] = "--- {$old_target}".PHP_EOL;
          $result[] = "+++ {$cur_target}".PHP_EOL;
    $diff = implode('', $result).PHP_EOL;
  private function isGitBinaryChange(ArcanistDiffChange $change) {
    $file_type = $change->getFileType();
    return ($file_type == ArcanistDiffChangeType::FILE_BINARY ||
            $file_type == ArcanistDiffChangeType::FILE_IMAGE);
  }

    $lines = phutil_split_lines($base_hunk->getCorpus());
      $corpus = implode('', $corpus);
        $result[] = "@@ -{$o_head} +{$n_head} @@".PHP_EOL;

        $last = substr($corpus, -1);
        if ($last !== false && $last != "\r" && $last != "\n") {
          $result[] = PHP_EOL;
        }
    return implode('', $result);
  private function getBlob($phid, $name = null) {
    $console = PhutilConsole::getConsole();

      if ($name) {
        $console->writeErr("Downloading binary data for '%s'...\n", $name);
      } else {
        $console->writeErr("Downloading binary data...\n");
      }
  private function buildBinaryChange(ArcanistDiffChange $change, $old_binary) {
    // In Git, when we write out a binary file move or copy, we need the
    // original binary for the source and the current binary for the
    // destination.

    if ($old_binary) {
      if ($old_binary->getOriginalFileData() !== null) {
        $old_data = $old_binary->getOriginalFileData();
        $old_phid = null;
      } else {
        $old_data = null;
        $old_binary->getMetadata('old:binary-phid');
      }
    } else {
      $old_data = $change->getOriginalFileData();
      $old_phid = $change->getMetadata('old:binary-phid');
    }

    if ($old_data === null && $old_phid) {
      $name = basename($change->getOldPath());
      $old_data = $this->getBlob($old_phid, $name);
    }

    $old_length = strlen($old_data);
    if ($old_data === null) {
    $new_phid = $change->getMetadata('new:binary-phid');

    $new_data = null;
    if ($change->getCurrentFileData() !== null) {
      $new_data = $change->getCurrentFileData();
    } else if ($new_phid) {
      $name = basename($change->getCurrentPath());
      $new_data = $this->getBlob($new_phid, $name);
    }

    $new_length = strlen($new_data);

    if ($new_data === null) {
    $content[] = "index {$old_sha1}..{$new_sha1}".PHP_EOL;
    $content[] = "GIT binary patch".PHP_EOL;
    $content[] = "literal {$new_length}".PHP_EOL;
    $content[] = $this->emitBinaryDiffBody($new_data).PHP_EOL;
    $content[] = "literal {$old_length}".PHP_EOL;
    $content[] = $this->emitBinaryDiffBody($old_data).PHP_EOL;
    return implode('', $content);
      $buf .= PHP_EOL;