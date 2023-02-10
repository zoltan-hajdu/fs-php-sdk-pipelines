#!/bin/bash

. "$1/util.sh"
. "$1/core.sh" $1

init() {
  local sessionId=$(new_session ${CHROMEOPTIONS})

  BASE_URL=${ROOT}/session/$sessionId
}

detect_version
init $@
