#!/bin/bash - 
#===============================================================================
#
#          FILE: run-dev.sh
# 
#         USAGE: ./run-dev.sh 
# 
#   DESCRIPTION: 
# 
#       OPTIONS: ---
#  REQUIREMENTS: ---
#          BUGS: ---
#         NOTES: ---
#        AUTHOR: Pierre RABY (), 
#  ORGANIZATION: 
#       CREATED: 09/06/2017 15:27:19
#      REVISION:  ---
#===============================================================================


docker run --rm -v $(pwd)/webapp/src:/src -w /src -p 8080:8080 node:6 bash -c "npm install && npm run dev"
