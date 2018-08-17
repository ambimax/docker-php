NAME	= ambimax/php7.1-fpm-stretch
TAG		= $(shell git rev-parse --short HEAD)
IMG		= ${NAME}:${TAG}
LATEST	= ${NAME}:latest

build:
	@docker build --pull --cache-from "${NAME}" -t "${IMG}" .
	@docker tag ${IMG} ${LATEST}
	@docker tag ${IMG} ${NAME}:$(shell docker run ${IMG} php --version | head -n 1 | cut -d ' ' -f2 | cut -c1-6)

test:
	container-structure-test test --image "${IMG}" --config .test.yaml

official-test:
	~/official-images/test/run.sh "${IMG}"

push:
	@docker push ${NAME}

login:
	@docker login -u "${DOCKER_USER}" -p "${DOCKER_PASSWORD}"
