== Установка/Обновление ==

<h3 style="text-align: center;">Установка:</h3>
Т.к. это дополнение для WordPress плагина <a href="https://codeseller.ru/groups/plagin-wp-recall-lichnyj-kabinet-na-wordpress/" target="_blank">WP-Recall</a>, то оно устанавливается через <a href="https://codeseller.ru/obshhie-svedeniya-o-dopolneniyax-wp-recall/" target="_blank"><strong>менеджер дополнений WP-Recall</strong></a>.

1. В админке вашего сайта перейдите на страницу "WP-Recall" -> "Дополнения" и в самом верху нажмите на кнопку "Обзор", выберите .zip архив дополнения на вашем пк и нажмите кнопку "Установить".
2. В списке загруженных дополнений, на этой странице, найдите это дополнение, наведите на него курсор мыши и нажмите кнопку "Активировать". Или выберите чекбокс и в выпадающем списке действия выберите "Активировать". Нажмите применить.


<h3 style="text-align: center;">Обновление:</h3>
Дополнение поддерживает <a href="https://codeseller.ru/avtomaticheskie-obnovleniya-dopolnenij-plagina-wp-recall/" target="_blank">автоматическое обновление</a> - два раза в день отправляются вашим сервером запросы на обновление.
Если в течении суток вы не видите обновления (а на странице дополнения вы видите что версия вышла новая), советую ознакомиться с этой <a href="https://codeseller.ru/post-group/rabota-wordpress-krona-cron-prinuditelnoe-vypolnenie-kron-zadach-dlya-wp-recall/" target="_blank">статьёй</a>




== Настройки ==
Блока настроек нет

Имеется 2 шорткода. Вы можете разместить их в записи или в html виджете - перейдя в админке: Внешний вид -> Виджеты

1 шорткод <code>[otfm_online]</code> - выводит аватарки последних пользователей.

<strong>Дополнительные атрибуты шорткода:</strong>

<strong>exclude-online</strong> - исключить тех кто в сети. По умолчанию "no". Если не нужно выводить тех кто в сети ставьте "yes"

<strong>period</strong> - число. Время в часах за период который выводим. По умолчанию "24"

2 шорткод code>[otfm_count_online]</code> - выводит числом сколько человек были за период в сети.
Имеет те же 2 атрибута что и шорткод выше.

<h3>Примеры:</h3>

1. Выведем кто был в сети за 24 часа:

<code>[otfm_online]</code>

2. Выведем кто был в сети за 2 дня и исключим тех кто сейчас онлайн

<code>[otfm_online period="48" exclude-online="yes"]</code>

3. Выведем число сколько посетило за неделю

<code>Пользователей за неделю: [otfm_count_online period="168"]</code>

4. Число и аватарки за 10-ть дней

<pre>Пользователей: [otfm_count_online period="240"]
[otfm_online period="240"]</pre>




== Changelog ==
= 2019-08-05 =
v1.1
* Работа с дополнением Fake Online


= 2019-07-17 =
v1.0
* Release





== Прочее ==

* Поддержка осуществляется в рамках текущего функционала дополнения
* При возникновении проблемы, создайте соотвествующую тему на форуме поддержки товара
* Если вам нужна доработка под ваши нужды - вы можете обратиться ко мне в <a href="https://codeseller.ru/author/otshelnik-fm/?tab=chat" target="_blank">ЛС</a> с техзаданием на платную доработку.

Все мои работы опубликованы <a href="https://otshelnik-fm.ru/?p=2562&utm_source=free-addons&utm_medium=addon-description&utm_campaign=recently-online&utm_content=codeseller.ru&utm_term=all-my-addons" target="_blank">на моём сайте</a> и в каталоге магазина <a href="https://codeseller.ru/author/otshelnik-fm/?tab=publics&subtab=type-products" target="_blank">CodeSeller.ru</a>
