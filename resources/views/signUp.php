
    <fieldset class="signUp-form">
        <h1 class="signUp-form__titel"><?= $registerL ?></h1>
            <form action="/signUp/storeUser" method="post">
                <p>
                    <label>
                       <?= $enterNameL ?> <br>
                        <input type="text" name="login">
                    </label>
                </p>
                <p>
                    <label>
                        <?= $enterPasswordL ?> <br>
                        <input type="password" name="password">
                    </label>
                </p>
                <p>
                    <label>
                        <?= $repeatPasswordL ?> <br>
                        <input type="password" name="password2">
                    </label>
                </p>

                <p>
                    <label>
                        <?= $enterEmailL ?> <br>
                        <input type="email" name="email">
                    </label>
                </p>
                <br>
                <p>
                    <button class="signUp-form__button">OK</button>
                </p>
            </form>

    </fieldset>

