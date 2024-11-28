####
Setup
```sh
make
```

Go to http://localhost:8080/clients/create to create a client.

Go to http://localhost:8080/loan/check-eligibility to get check eligibility for a loan.

Go to http://localhost:8080/clients/{id}/edit add play with properties to see how the loan eligibility changes.

### Условия выдачи кредита
* Кредитный рейтинг клиента должен быть выше 500.
* Ежемесячный доход клиента должен быть не менее $1000.
* Возраст клиента должен быть от 18 до 60 лет.
* Кредиты выдаются только в штатах CA, NY, NV.
* Клиентам из штата NY отказ производится случайным образом.
* Клиентам из штата Калифорния процентная ставка увеличивается на 11.49%.
