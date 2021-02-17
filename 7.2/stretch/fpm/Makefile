NAME	= ambimax/php7.2-fpm-stretch
TAG		= $(shell git rev-parse --short HEAD)
IMG		= ${NAME}:${TAG}
LATEST	= ${NAME}:latest
ROOT 	= $(shell dirname $(shell dirname $(shell dirname "${PWD}")))

build: build-image tag-main-version tag-version tag-latest

build-image:
	@docker build --pull --cache-from "${NAME}" -t "${IMG}" .

tag-latest:
	docker tag ${IMG} ${LATEST}

tag-version:
	$(eval $@_PHP_TAG := ${NAME}:$(shell docker run ${IMG} php --version | head -n 1 | cut -d ' ' -f2 | cut -c1-6))
	docker tag "${IMG}" "$($@_PHP_TAG)"

tag-main-version:
	$(eval $@_PHP_TAG := ${NAME}:$(shell docker run ${IMG} php --version | head -n 1 | cut -d ' ' -f2 | cut -c1-3))
	docker tag "${IMG}" "$($@_PHP_TAG)"

test:
	container-structure-test test --image "${IMG}" --config .test.yaml

official-test:
	~/official-images/test/run.sh "${IMG}"

dockerhub-description:
	@docker run --volume "${ROOT}:/workspace" \
		--env DOCKERHUB_USERNAME='${DOCKER_USER}' \
		--env DOCKERHUB_PASSWORD='${DOCKER_PASSWORD}' \
		--env DOCKERHUB_REPOSITORY='${NAME}' \
		--env README_FILEPATH='/workspace/README.md' \
		peterevans/dockerhub-description:2

push: dockerhub-description
	@docker push ${NAME}

login:
	@docker login -u "${DOCKER_USER}" -p "${DOCKER_PASSWORD}"
