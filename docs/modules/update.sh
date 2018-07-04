#!/bin/bash

USER=rhubarbphp;PAGE=1; curl -k "https://api.github.com/users/$USER/repos?page=$PAGE&per_page=100" | grep -e 'git_url*' | cut -d \" -f 4 | tr '[A-Z]' '[a-z]' | sed 's|git://github.com/|git@github.com:|' | xargs -L1 git clone
USER=rhubarbphp;PAGE=1; curl -k "https://api.github.com/users/$USER/repos?page=$PAGE&per_page=100" | grep -e 'git_url*' | cut -d \" -f 4 | tr '[A-Z]' '[a-z]' | cut -d / -f 5 | sed 's/\.git//' | xargs -L1 -I % sh -c 'git -C % pull;cd %;composer install --no-dev --ignore-platform-reqs;'
