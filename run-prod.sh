#!/bin/bash - 
#===============================================================================
#
#          FILE: run-prod.sh
# 
#         USAGE: ./run-prod.sh 
# 
#   DESCRIPTION: 
# 
#       OPTIONS: ---
#  REQUIREMENTS: ---
#          BUGS: ---
#         NOTES: ---
#        AUTHOR: Pierre RABY (), 
#  ORGANIZATION: 
#       CREATED: 09/06/2017 15:35:10
#      REVISION:  ---
#===============================================================================


docker run --rm -v $(pwd)/webapp/src/:/src -w /src node:6 bash -c "npm install && npm run build"
