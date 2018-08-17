NAME	= ambimax/php7.1-cli-stretch
TAG		= $(shell git rev-parse --short HEAD)
IMG		= ${NAME}:${TAG}
LATEST	= ${NAME}:latest

prepare:
	@docker pull ${NAME}

build:
	@docker build --pull --cache-from "${NAME}" -t "${IMG}" .
	@docker tag ${IMG} ${LATEST}

test:
	container-structure-test test --image "${IMG}" --config .test.yaml

official-test:
	~/official-images/test/run.sh "${IMG}"

push:
	@docker push ${NAME}

login:
	@docker login -u "$DOCKER_USER" -p "$DOCKER_PASSWORD"