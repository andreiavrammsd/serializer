.PHONY: qa build

IMAGE := andreiavrammsd/serializer

all: qa test

build:
	docker build . -f dev/Dockerfile -t $(IMAGE)
	docker run -ti --rm -v $(CURDIR):/src $(IMAGE) composer install

push:
	docker push $(IMAGE)

run:
	docker run -ti --rm -v $(CURDIR):/src $(IMAGE) sh

test:
	docker run -ti --rm -v $(CURDIR):/src $(IMAGE) ./dev/test.sh

qa:
	docker run -ti --rm -v $(CURDIR):/src $(IMAGE) ./dev/qa.sh
