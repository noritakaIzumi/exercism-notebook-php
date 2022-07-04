test:
	docker-compose run --rm php bash exec_test.sh ${NAME}

submit:
	exercism submit ./${NAME}/${NAME}.php
