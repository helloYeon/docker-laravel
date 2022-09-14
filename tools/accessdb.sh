#!/bin/bash
#set -Cu
#******************************************************************************
# access db
#
# usage
#     sh tools/accessdb.sh {local|dev|prod}
#
#******************************************************************************
cd $(dirname ${0})

ENV=""
EXT_SQL=""
CMD_INFO="sh tools/accessdb.sh {local|dev|stg|prod}"

# [CHECK] PARAM ENV
if [[ ! "${1}" =~ ^(local|dev|stg|prod)$ ]]; then
	echo "[ERROR] INVALID PARAMETER : ${CMD_INFO}"
	exit 1
fi

# [SET] ENV
ENV=$1

# [CHECK] PARAM EXTENAL SQL
if [[ -n ${2} ]]; then
	EXT_SQL="-e '${2}'"
fi

# local env
if [[ ${ENV} == "local" ]]; then
    CMD="mysql -udocker_laravel -P33064 -pdocker_laravel -Ddocker_laravel_db --protocol tcp ${EXT_SQL}"

# dev env
elif [[ ${ENV} == "dev" ]]; then
    echo "write the [dev enviroment] access command"
# prod env
else
    echo "write the [prod enviroment] access command"
fi

eval ${CMD}

exit 0
