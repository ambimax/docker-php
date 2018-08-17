NAME	= ambimax/php7.0-fpm-stretch
TAG		= $(shell git rev-parse --short HEAD)
IMG		= ${NAME}:${TAG}
LATEST	= ${NAME}:latest

build:
	@docker build --pull --cache-from "${NAME}" -t "${IMG}" .
	@docker tag ${IMG} ${LATEST}

test:
	container-structure-test test --image "${IMG}" --config .test.yaml

official-test:
	(set -Eeuo pipefail && set -x && ~/official-images/test/run.sh "${IMG}")

push:
	@docker push ${NAME}

login:
	@docker login -u "${DOCKER_USER}" -p "${DOCKER_PASSWORD}"