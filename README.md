mmxSuperShop
---
Пример разработки дополнения на основе [mmxApp](https://github.com/bezumkin/mmx-app).

> Это дополнение является частью инициативы **MMX** - то есть **M**odern **M**OD**X** (современный MODX).

### Видео

Код этого дополнения был написан в рамках обучающих видеороликов, которые можно посмотреть:
- [YouTube](https://www.youtube.com/playlist?list=PLo8DEw5gy_100rXRsbomY6yp4RRonan8W)
- [Rutube](https://rutube.ru/plst/404725)

### Установка

1. Проверить, присутствует ли `composer.json` в корне сайта. Если нет - установить:
```
cd /to/modx/root/
wget https://raw.githubusercontent.com/modxcms/revolution/v3.0.5-pl/composer.json
```

2. Добавить репозитории дополнения:
```
composer config repositories.mmx-super-shop vcs https://github.com/bezumkin/mmx-app-super-shop-test
```

3. (опционально) Если вы на modhost.pro, то подготовить консольный PHP:
```
mkdir ~/bin
ln -s /usr/bin/php8.1 ~/bin/php
source ~/.profile
```

4. Установить дополнение
``` 
composer require mmx/super-shop
```

5. Запустить установку компонента в MODX
```
composer exec mmx-super-shop install  
```

Обязательные дополнения `mmx/database` и `mmx/fenom` будут скачаны и установлены автоматически.

### Удаление

Для удаления дополнения нужно выполнить команды в обратном порядке:
```
composer exec mmx-super-shop remove
composer remove mmx/super-shop
```

Если вам больше не нужны Fenom и Database - их тоже можно удалить:
```
composer exec mmx-fenom remove && composer remove mmx/fenom

composer exec mmx-database remove && composer remove mmx/database
```