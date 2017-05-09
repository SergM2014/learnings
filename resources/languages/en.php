<?php

$attrLang = "en";
$siteDescriptionL = "Learning site";


$ourBrandL = "Our Brand";
$mainCustomerPageL = "To the customer part";
$mainPageL = "Main";
$enterAdminL = "Enter";
$welcomeL = "Wellcome";
$adminZoneL = "Admin zone";
$searchL = "Search";
$footerDisclaimerL = "Das ich bin 2012-2017";
$variableInController = "that is controller";


$backToSiteL = "Back to site";
$adminEntryTitleL = "Enter to admin Zone";
$loginTitleL = "Login";
$passwordL = "Password";

$youAreInAdminL = "Admin zone";
$exitL = "exit";
$registerL = "Register";
$mainTitleExplanationL = "This is the learning Resource Center";
$testimonialsL = "Testimonials";
$lookThroughTestimonialsL = "Read all testimonials";
$serieL = "serie";
$seriesL = "series";
$extraLessonL = "extra lesson";
$extraLessonsL = "extraLessons";
$level1L = "beginner";
$level2L = "intermidiate";
$level3L = "advanced";
$lessonL = "lesson";
$lessonsL = "lessons";
$seriesBeadcrumbsL = "Series";
$testemonialsL= "Testemonials";
$underVideoLessonsL = "Lessons";
$commentsL = "Comments";
$registerL = "Sign UP";
$enterNameL = "Enter name";
$enterPasswordL = "Enter password";
$enterEmailL = "Enter Email";
$repeatPasswordL = "Repeat password";
$signUpSecceededL = "Greetings!!! You are signedUp!";
$rememberMeL = "Remember me";
$signInSecceededL = "Greetings!! You are signedIn!";
$alreadySignedIn = "You are already signed in!";
$enterL = "Enter";
$downloadL = "Download";
$loginL = "Login";
$addCommentL = "Add Comment!";
$deleteL = "Delete";
$settingsL = "Settings";
$profileL = "Profile";
$changeNameL= "Change Name";
$changePasswordL = "Change Password";
$changeEmailL = "Change Email";
$subscripedTillL = "Subscriped till  ";
$unsubscriped = "The total user is totally unsubscriped";
$editProfileL = "Edit Profile";
$deletePreviewL = "Delete preview";
$sendCommentL = "Add comment";
$enterCaptchaL = "Enter captcha";
$clickToRefreshL = "Click to refresh";
$enterCommentL = "Enter comment";
$commentAdded = "Your comment is added. It will be published after moderation!";
$giveResponseToComment = "Response the comment";
$responseGivvenComment = "The comment to response";
$videoIsNotAccessible = "Video is not accessible!";
$subscribedOnlyUser = "Subscribed only users!";
$seriesLessonsL = "Series Lessons";
$nothingFound = "Nothing is found!";
$enterTestimonialL = "Enter testimonial";
$addTestimonialL = "Add testimonial";
$testimonialsForLoggedInL = "Only logged in users add testimonials";
$testimonialAddedL = "Yor testemonial is added.It will be published after moderator review";
$gotoLessonL = "Go to lesson";
$closeL = "Close";
$loginToAddCommentL = "Login to add the comment";
$adminGreetings = "Greetings! You entered admin zone now";
$lessonsTitlesL = "Lessons";
$titleL = "Title";
$excerptL = "Excerpt";
$showL = "Show";
$updateL = "Update";
$addL = "Add";
$shooseSerieL = "Choose serie";
$setPayedStatusL = "Set payed status";
$freeL = "Free";
$notFreeL = "Not free";
$createLessonL = "Create Lesson";
$iconL = "Icon";
$fileL = "File";
$lessonFileUploadRemark = "mp4 extention only! Size not more than 100Mb";
$lessonAdded = "Lesson is successfuly added!";
$updateLessonL = "Update Lesson";
$lessonUpdatedL = "Lesson is Updated!";
$serieTitleL = "Serie Title";
$categoryTitleL = "Category Title";
$videoTitleL = "VideoTitle";
$noVideoL = "No video file";
$payStatusL = "Pay status";
$backL = "Back";
$cancelL = "Cancel";
$yesL = "Yes";
$shureDeleteLessonL = "Are You shure to delete the lesson?";
$category_serieTitleL = "Category/Serie";
$commentsNumberL = "Comments number";
$noSerieTitleL = "No serie";
$newFirstL = "New first";
$oldFirstL = "Old first";
$abcL = "ABC";
$abcBackwardsL = "abc backwards";
$moreCommentsFirstL = "more comments first";
$lessCommentsFirstL = "less comments first";
$addedAtL = "Added at";
$selectAllL = "Select all";
$orderByL = "Order by";
$renameL = "Rename";
$createSerieL = "Create serie";
$difficultyLevelL = "Difficulty level";
$lowL = "Low";
$middleL = "Middle";
$highL = "High";
$updateSerieL = "Update Serie";
$serieUpdatedL = "Serie is updated!";
$shureDeleteSerieL = "are you shure to delete the serie?";
$createSerieL = "Create serie";
$serieAddedL = "Serie added!";
$createL = "Create";
$createCategoryL = "Create Category";
$categoryAddedL = "Category Added!";
$updateCategoryL = "Update Category";
$categoryUpdatedL = "Category is updated!";
$shureDeleteCategoryL = "Are you shure to delete the category ?";
$responseL = "Response";
$userL = "User";
$publishedL = "Published";
$changedL = "Changed";
$avatarL = "Avatar";
$noL = "No";
$editL = "Edit";
$publishL = "Publish";
$unpublishL = "Unpublish";
$editTestimonialL = "Edit Testimonial";
$testimonialUpdatedL = "Testimonial is updated!";
$unpublishedL = "Unpublished";
$notChangedL = "Not changed";


//these functionare for translation in controllers and models
function variableInController(){
    return "Variable in Controller";
}

function repeatVariableInController(){
    return "Variable in controller again";
}

function emptyField()
{
    return "empty field!";
}

function notEqualRepeatedPassword()
{
    return 'Wrong repeated password!';
}

function notApropriateLength()
{
    return "Too short field";
}

function wrongEmail()
{
    return "Wrong email format";
}

function smthWentWrong()
{
    return "Something went wrong!";
}
function repeatedLogin()
{
    return "Login is already taken";
}

function succededRegistrationMail($login, $password)
{
    return "Congratulations ! \n 
    Your login - $login \n
    Your password - $password";
}

function restrictedFileType()
{
    return "Restricted file type!!";
}

function tooBigFile()
{
    return "too big file size!";
}

function succeededUpload()
{
    return "File Uploaded!";
}

function smthIsWrong()
{
    return "Something went wrong!";
}

function fileDeleted()
{
    return "File is deleted!";
}

function wrongCaptcha()
{
    return "Wrong captcha!";
}
function responseGivvenComment()
{
    return "Response the comment!";
}

function noCategoryAndSerie()
{
    return "Empty category/serie!";
}

function noFile()
{
    return "No file!";
}

function lessonIsDeleted()
{
    return "Lesson is deleted!";
}

function serieHasLessons()
{
    return "Impposible to delete! The serie has lessons!";
}

function serieDeleted()
{
    return "The serie is deleted!";
}

function categoryHasLessons()
{
    return "Impposible to delete! The category has lessons!";
}

function categoryDeleted()
{
    return "Category is deleted!";
}

function categoryHasSeries()
{
    return "Impposible to delete! The category has series!";
}

function testimonialIsPublished()
{
    return "Testimonial is published!";
}

function testimonialIsUnpublished()
{
    return "Testimonial is unpublished!";
}

function yes()
{
    return "Yes";
}

function no()
{
    return "No";
}