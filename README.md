File-manager - система по управлению файлами.

Требования (технологии): PHP 8.4, Composer, Laravel 12, MySQL (или другая СУБД)

Чтобы запустить этот проект локально, выполните следующие шаги:

1.  **Клонируйте репозиторий:**
    ```bash
    git clone https://github.com/temastraik/file-manager
    cd file-manager
    ```

2.  **Установите зависимости PHP:**
    ```bash
    composer install
    ```

3.  **Настройте environment-файл:**

    Скопируйте файл `.env.example` в `.env` и настройте базовые параметры Laravel.
    
    *Настройте Базу данных по вашим параметрам*
    
    <img width="172" height="116" alt="image" src="https://github.com/user-attachments/assets/a7f2a96d-fabc-438c-a2b0-2736b2179f30" />

5.  **Запустите миграции:**
    ```bash
    php artisan migrate
    ```

Функционал:

- Загрузка, удаление и скачивание любых файлов, полное описание к каждому добавленному файлу;

<img width="1311" height="484" alt="image" src="https://github.com/user-attachments/assets/0fcaa1cb-47cf-4bc5-8734-026dae9d67e3" />


- Автоматическая группировка и фильтрация;

<img width="1305" height="77" alt="image" src="https://github.com/user-attachments/assets/e78435e0-4dca-4127-b6dd-c9d65395c685" />



- Создание пользовательских групп по управлению файлами;

<img width="1312" height="248" alt="image" src="https://github.com/user-attachments/assets/00852a4c-130b-4e9d-beb1-4708f7825853" />

- Просмотр файлов в определнной группе.

<img width="1302" height="415" alt="image" src="https://github.com/user-attachments/assets/599fce39-28fa-4051-b415-e25cbba70f69" />



