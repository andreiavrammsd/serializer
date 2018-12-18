.PHONY: build push install qa run clean

ifndef PHPVERSION
$(error PHPVERSION is not set)
endif

IMAGE := andreiavrammsd/serializer:php$(PHPVERSION)

all: qa

build:
	docker build --build-arg PHPVERSION=$(PHPVERSION) . -f dev/Dockerfile -t $(IMAGE)

push:
	docker push $(IMAGE)

install:
	docker pull $(IMAGE)
	docker run -ti --rm -v $(CURDIR):/src $(IMAGE) composer install

qa:
	docker run -ti --rm -v $(CURDIR):/src $(IMAGE) ./dev/qa.sh

run:
	docker run -ti --rm -v $(CURDIR):/src $(IMAGE) sh

clean:
	docker rmi $(IMAGE)
