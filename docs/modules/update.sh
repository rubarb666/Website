#!/bin/bash

USER=rhubarbphp;PAGE=1; curl "https://api.github.com/users/$USER/repos?page=$PAGE&per_page=100" | grep -e 'git_url*' | cut -d \" -f 4 | tr '[A-Z]' '[a-z]' | xargs -L1 git clone
USER=rhubarbphp;PAGE=1; curl "https://api.github.com/users/$USER/repos?page=$PAGE&per_page=100" | grep -e 'git_url*' | cut -d \" -f 4 | tr '[A-Z]' '[a-z]' | cut -d / -f 5 | sed 's/\.git//' | xargs -L1 -I % git -C % pull
