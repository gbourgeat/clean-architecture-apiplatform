#!/usr/bin/env bash

JWT_KEYPAIR_PATH="./docker/jwt";

rm -rf ${JWT_KEYPAIR_PATH} && mkdir ${JWT_KEYPAIR_PATH} && cd ${JWT_KEYPAIR_PATH}

echo "== Generate JWT Keypair in ${JWT_KEYPAIR_PATH}"

ssh-keygen -t rsa -P "" -b 4096 -m PEM -f private.pem > /dev/null
ssh-keygen -e -m PEM -f private.pem > public.pem
rm private.pem.pub

echo "JWT Keypair generated with success !"
