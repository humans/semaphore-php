.ONESHELL:
DIST_DIRECTORY=.vuepress/dist

build:
	vuepress build

persist:
	cd $(DIST_DIRECTORY)
	git init
	git add -A
	git commit -m 'deploy'

deploy: build persist
	cd $(DIST_DIRECTORY)
	git push -f git@github.com:humans/semaphore-php.git master:gh-pages