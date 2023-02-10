#!/bin/bash

# text colors
RED='\e[1;31m'
GREEN='\e[1;32m'
ORIGINAL='\e[0m'

DATE=$(date +'%m-%d-%Y-%k%M%S')

changed=1
composer_error=0

cd ./bitbucket_source

branch_name=$(git symbolic-ref --short -q HEAD)

if [ $branch_name != 'develop' ]; then
    git checkout develop
fi

git fetch && git status -uno | grep -q 'up to date' && changed=0

if [ $changed = 1 ]; then
    echo "Updating the environment."

    git pull

    cd ~/environment

    rsync -av -- ./PHP_SDK/* ./PHP_SDK_BACKUP/

    rsync -av --exclude-from='rsync_exclude.txt' -- ./bitbucket_source/* ./PHP_SDK/

    # composer

    mkdir -p ~/environment/vendor_backups

    cd ~/environment/PHP_SDK

    cp -a ./vendor/. ~/environment/vendor_backups/$DATE/

    rm -rf ./vendor

    # rm -f ./composer.lock

    composer install --dry-run 2>&1 | grep -A3 -w 'Problem' 2>&1 | grep --color=never '-' && composer_error=1

    if [ $composer_error = 0 ]; then
        composer install
        echo $GREEN"The environment is up-to-date."$ORIGINAL
    else
        # copy backup data to vendor
        mkdir -p ~/environment/PHP_SDK/vendor
        cp -a ~/environment/vendor_backups/$DATE/. ~/environment/PHP_SDK/vendor/
        echo $RED"Something went wrong, check the errors and run composer install again."$ORIGINAL
    fi
else
    echo $GREEN"The environment is up-to-date."$ORIGINAL
fi