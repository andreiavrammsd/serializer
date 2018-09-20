.PHONY: qa build

all: qa test

build:
	docker build . -f dev/Dockerfile -t serializer
	docker run -ti --rm -v $(CURDIR):/src serializer composer install

run:
	docker run -ti --rm -v $(CURDIR):/src serializer sh

test:
	docker run -ti --rm -v $(CURDIR):/src serializer ./dev/test.sh

qa:
	docker run -ti --rm -v $(CURDIR):/src serializer ./dev/qa.sh
