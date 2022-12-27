#!/usr/bin/env bash
rm -rf ./docker/certs
mkdir ./docker/certs
cd ./docker/certs
mkcert -install;
mkcert --cert-file ./localhost.crt --key-file ./localhost.key localhost "api.lab-ddd.localhost" 127.0.0.1 ::1;
cp "$(mkcert -CAROOT)/rootCA.pem" ./localCA.crt;
