.PHONY: build

IMAGE := andreiavrammsd/serializer

all: qa

build:
	docker build . -f dev/Dockerfile -t $(IMAGE)

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
