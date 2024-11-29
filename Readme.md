####
Setup
```sh
make
```

Go to http://localhost:8080/clients/create to create a client.

Go to http://localhost:8080/clients to see created clients.

Go to http://localhost:8080/loan/check-eligibility to get check eligibility for a loan.

Go to http://localhost:8080/clients/{id}/edit add play with properties to see how the loan eligibility changes.

On a non denied loan click "Take Loan!" and see logs with mocked message sent.
```sh
docker compose logs -n 2 consumer
```

Then go to http://localhost:8080/clients/{id}/edit and change the messaging channel, take the loan again and see logs with the new message sent.
You should see something like this: 

```log
Message sent by Email driver to ilijas9813@gmail.com: Dear Iliyas Akbergen, Loan with ID 81143513-86c6-4a4a-a582-4a244152706b has been created
2024-11-29T01:17:01.414050549Z Message sent by Sms driver to +420771286627: Dear Iliyas Akbergen, Loan with ID a967ea16-de00-4fb6-9414-2979d16887bd has been created
```


### Условия выдачи кредита
* Кредитный рейтинг клиента должен быть выше 500.
* Ежемесячный доход клиента должен быть не менее $1000.
* Возраст клиента должен быть от 18 до 60 лет.
* Кредиты выдаются только в штатах CA, NY, NV.
* Клиентам из штата NY отказ производится случайным образом.
* Клиентам из штата Калифорния процентная ставка увеличивается на 11.49%.
