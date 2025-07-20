docs:
	php artisan l5-swagger:generate

work-queues:
	php artisan queue:work

clear-logs:
	echo "" > storage/logs/laravel.log
