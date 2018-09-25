.PHONY: build

IMAGE := andreiavrammsd/serializer

all: qa

build:
	docker build . -f dev/Dockerfile -t $(IMAGE)
	docker run -ti --rm -v $(CURDIR):/src $(IMAGE) composer install

push:
	docker push $(IMAGE)

run:
	docker run -ti --rm -v $(CURDIR):/src $(IMAGE) sh

qa:
	docker run -ti --rm -v $(CURDIR):/src $(IMAGE) ./dev/qa.sh
