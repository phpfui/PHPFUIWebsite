            $vars = $this->consumeRegexp("/diff --git \"?(a\/.*?)\"? \"?(b\/.*?)\"?\n/");
                //verifying if the file was deleted or created
                    $oldName = $this->consumeTo("\n") === '/dev/null' ? '/dev/null' : $oldName;
                    $newName = $this->consumeTo("\n") === '/dev/null' ? '/dev/null' : $newName;
                    $vars = $this->consumeRegexp('/"?(.*?)"? and "?(.*?)"? differ\n/');
