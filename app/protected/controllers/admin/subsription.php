<?php

namespace App\Controllers\Admin;



use App\Core\AdminController;

use App\Models\Comment as CommentModel;
use App\Models\Subscription as SubscriptionModel;
use Lib\TokenService;
use App\Models\CheckForm;

class Subscription extends AdminController {

    public function index($errors = null )
    {
        $subscriptionPlan = SubscriptionModel::getSubscriptionInfo();

        $_SESSION['editSubscriptionPlan'] = true;

        return ['view'=>'views/admin/subscription/index.php', 'subscriptionPlan' => $subscriptionPlan, 'errors' => $errors];
    }


    public function update()
    {
        TokenService::check('admin');

        if(!@$_SESSION['editSubscriptionPlan']) return $this->index();

        $cleanedUpInputs = self::escapeInputs('plan_description_uk', 'plan_description_en');

        $errors = CheckForm::checkSubscriptionPlanForm($cleanedUpInputs);


        if(!empty($errors) ) {

            return $this->index($errors);
        }

        SubscriptionModel::updateSubscriptionPlan($this->stripTags($_POST['plan_description_uk']), $this->stripTags($_POST['plan_description_en']));

        unset ($_SESSION['editSubscriptionPlan']);

        return  ['view' => '/views/admin/subscription/updateSuccess.php'];
    }






}
  