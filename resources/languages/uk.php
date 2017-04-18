<?php

$attrLang = "uk";
$siteDescriptionL = "Сайт для навчання";


$ourBrandL = "Наш Бренд";
$mainCustomerPageL = "До користувацької частини";
$mainPageL = "Головна";
$enterAdminL = "Війти";
$welcomeL = "Вітаемо";
$adminZoneL = "Адмiн зона";
$searchL = "Пошук";
$footerDisclaimerL = "Das ich bin 2012-2017";

$backToSiteL = "Назад до сайту";
$adminEntryTitleL = "Вхід до адмін зони";
$loginTitleL = "Логін";
$passwordL = "Пароль";

$youAreInAdminL = "Адміністративна частина";
$exitL = "Вихід";
$registerL = "Зарееструватися";
$mainTitleExplanationL = "Навчальний ресурс-центр";
$testimonialsL = "Рекомендації";
$lookThroughTestimonialsL = "Переглянути всі рекомендації";
$serieL = "cерія";
$seriesL = "cерій";
$extraLessonL = "додатковий урок";
$extraLessonsL = "додаткових уроків";
$level1L = "Початковий";
$level2L = "Середній";
$level3L = "Виший";
$lessonL = "урок";
$lessonsL = "уроків";
$seriesBeadcrumbsL = "Серії";
$testemonialsL = "Відгуки та рекомендації";
$underVideoLessonsL = "Уроки";
$commentsL = "Коментарії";
$registerL = "Зарееструватися";
$enterNameL = "Введіть ваше Імя";
$enterPasswordL = "Bведіть пароль";
$enterEmailL = "Введіть Email";
$repeatPasswordL = "Повторіть пароль";
$signUpSecceededL = "Поздоровляю Вас зареестровано";
$signInSecceededL = "Поздоровляю Ви успішно ввійшли в акаунт";
$rememberMeL = "Запамятати мене";
$alreadySignedIn = "Вас вже зареестровано на сайті!";
$enterL = "Ввійти";
$downloadL = "Завантажити";
$loginL = "Війти";
$addCommentL = "Додати коментар!";
$deleteL = "Видалити";
$settingsL = "Налаштування";
$profileL = "Профіль";
$changeNameL= "Змінити Імя";
$changePasswordL = "Змінити пароль";
$changeEmailL = "Змінити Email";
$subscripedTillL = "Підписаний до ";
$unsubscriped = "Користувач непідписаний на жоден план";
$editProfileL = "Редагувати профіль";
$deletePreviewL = "Видалити зоображення";
$sendCommentL = "Додати коментарій";
$enterCaptchaL = "Введіть капчу";
$clickToRefreshL = "Клікніть щоб обновити";
$enterCommentL = "Введіть комментар";
$commentAdded = "Ваш коментар доданою Його буде опублікованно після перегляду модератором!";
$giveResponseToComment = "Дати відповідь на комментар";
$responseGivvenComment = "Комментар для відповіді";
$videoIsNotAccessible ="Відео не доступне!";
$subscribedOnlyUser = "Лише для підпісанних користувачів";
$seriesLessonsL = "Уроки Серії";
$nothingFound = "Нічого не знайдено!";
$enterTestimonialL = "Введіть відгук";
$addTestimonialL = "Додати відгук";
$testimonialsForLoggedInL = "Тільки зареєстровані користувачі можуть залишати рекомендації";
$testimonialAddedL = "Ваш відгук додано його буде опубліковано після перегляду модератором";
$gotoLessonL = "Перейти до урока";
$closeL = "Закрити";
$loginToAddCommentL ="Ввійдіть, щоб добавити коментар";
$adminGreetings = "Вітаю ви війшли до адміністративної зони";
$lessonsTitlesL = "Уроки";
$titleL = "Назва";
$excerptL = "Витяг";
$showL = "Продивитися";
$updateL = "Оновити";
$addL = "Додати";
$shooseSerieL = "Визначити серію";
$setPayedStatusL = "Визначити оплачуваний статус";
$freeL = "Безкоштовний";
$notFreeL = "Платний";
$createLessonL = "Створити урок";
$iconL = "Иконка";
$fileL = "Файл";
$lessonFileUploadRemark = "Лише mp4 розширення! Розмір не більше  100Mb";
$lessonAdded = "Урок успішно додано!";
$updateLessonL = "Оновити урок";
$lessonUpdatedL = "Урок оновленно!";


//these functionare for translation in controllers and models
function variableInController(){
    return "Змінна що в контролері";
}

function repeatVariableInController(){
    return "Знову Змінна що в контролері";
}

function emptyField()
{
    return "Пусте поле!";
}

function notEqualRepeatedPassword()
{
    return 'Невірно повторенний пароль!';
}

function notApropriateLength()
{
    return "Замало символів";
}

function wrongEmail()
{
    return "Неправильній формат email";
}

function smthWentWrong()
{
    return "Щось пішло не так!";
}

function repeatedLogin()
{
    return "Логін вже занйнято";
}

function succededRegistrationMail($login, $password)
{
    return "Прийміть поздлровлення ! \n 
    Ваш логін - $login \n
    пароль - $password";
}

function restrictedFileType()
{
    return "Заборонений тип файлу!";
}

function tooBigFile()
{
    return "Занадто великий розмір файлу!";
}

function succeededUpload()
{
    return "Файл завантаженно!";
}

function smthIsWrong()
{
    return "Щось пішло не так!";
}

function fileDeleted()
{
    return "Файл видалено!";
}

function wrongCaptcha()
{
    return "Неправильна капча!";
}
function responseGivvenComment()
{
    return "Відповісти на комментар!";
}

function noCategoryAndSerie()
{
    return "Не вказана категорія/серія!";
}

function noFile()
{
    return "Відсутній файл!";
}

