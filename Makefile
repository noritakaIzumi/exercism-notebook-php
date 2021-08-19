test:
	docker-compose run --rm php ./exec_test.sh ${NAME}

submit:
	exercism submit ./${NAME}/${NAME}.php
