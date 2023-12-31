<?php

use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faqs')->insert(
        [
            'heading' => "WHAT MAKES CryptoCash Exchange DIFFERENT?",
            'desc' => "Secure platform – CryptoCash Exchange employs the most reliable, effective security technologies available. We leverage an elastic, multi-stage wallet strategy to ensure that the majority of funds are kept in cold storage for additional safety. Also, CryptoCash Exchange enables two-factor authentication for all users and provides a host of additional security features to provide multiple layers of protection. At CryptoCash Exchange, security will always be a top priority in every decision we make. Custom-built trading engine – Our custom trading engine was designed to be scalable and to ensure that orders are executed in real-time. We also support third-party trading platforms and algorithmic trading via our extensive APIs. Fast deposits and withdrawals – Our highly efficient and automated monitoring platform allows us to provide users the fastest transactions available today. This includes updates on balance, trade, and wallet information. Driving Innovation – To help drive innovation in the blockchain industry, CryptoCash Exchange is committed to supporting both new and established blockchains. CryptoCash Exchange seeks to provide its users with an ever-growing selection of blockchain technologies and digital tokens, and all new digital tokens listed on the trading platform must complete a rigorous review process. Commitment to compliance – CryptoCash Exchange is committed to complying with all current regulations in the respective jurisdiction that help prevent, detect and remediate unlawful behavior by customers and virtual currency developers when using the CryptoCash Exchange trading platform or any of the company’s other services.",
            'created_at' => date("Y-m-d H:i:s"),
             'updated_at' => date("Y-m-d H:i:s"),     
        ]);


        DB::table('faqs')->insert(
        [
            'heading' => "GET STARTED ON CryptoCash Exchange ?",
            'desc' => "Simply go to the signup page, enter your information, and submit the form. Then check your email for the secret code that we’ve sent you. Use it to activate your account. Important: After you activate the account, check your email again to find important information we’ve sent about your account. Next, go to Account > Get Verified to verify the account. Once verified, go to Account > Funding > Deposit to make a deposit. Once your account is funded, you can start trading!",
            'created_at' => date("Y-m-d H:i:s"),
             'updated_at' => date("Y-m-d H:i:s"),     
        ]);



        DB::table('faqs')->insert(
        [
            'heading' => "HOW TO SIGN UP ON CryptoCash Exchange ?",
            'desc' => "To create an account, first make sure you are visiting the official CryptoCash Exchange site at https://www.cryptocash.com. You can quickly create an account directly on the home page by typing your email, preferred username, and password. The minimum password length is 8 characters but we recommend using a long unique password created by a password manager. If the password is less than 25 characters long, it must contain one special character, one number, and cannot contain your username. Please read and agree to our terms of service and privacy policy, before checking the box and clicking “Sign Up”. For more advanced options you can click the “Sign Up” button at the top right of the home page which will take you to https://www.CryptoCash Exchange.net/signup. Please confirm your password, complete the captcha and click the “Activate Account” button. Congratulations! You have successfully created your CryptoCash Exchange account and you’re ready to get started.",
            'created_at' => date("Y-m-d H:i:s"),
             'updated_at' => date("Y-m-d H:i:s"),     
        ]);


        DB::table('faqs')->insert(
        [
            'heading' => "DOES CryptoCash Exchange PROVIDE A WALLET SERVICE?",
        'desc' => "CryptoCash Exchange is an exchange service, not a wallet service. We provide clients the ability to deposit and withdraw funds to our corporate wallet for safe keeping while the funds are being exchanged or trade, but we do not provide a personal wallet service. CryptoCash Exchange uses cold storage and a hot wallet like many digital asset exchanges, so your sending address for a digital asset will not be the same as your deposit address. Do not attempt to withdraw digital assets from CryptoCash Exchange if ownership of the sending address is relevant to the transaction (for example, if you’re depositing into an Initial Coin Offering (ICO) address, CryptoCash Exchange hot wallet will be the depositor and not your personal CryptoCash Exchange deposit address). If you do deposit to a CryptoCash Exchange address that is not listed on your deposit page, it will not be possible for us to return the funds. It is your responsibility to ensure that the address to which you are depositing is listed on your deposit page. If you withdraw from CryptoCash Exchange to a third party that returns the withdrawal to the address from which it was sent, those assets will not be recoverable by CryptoCash Exchange. Please take the relevant steps to prevent your funds from being sent to addresses that are not listed on the deposit page of your account.",
            'created_at' => date("Y-m-d H:i:s"),
             'updated_at' => date("Y-m-d H:i:s"),     
        ]);

   

          DB::table('faqs')->insert(
        [
            'heading' => "HOW DO I BUY AND SELL CURRENCY ON CryptoCash Exchange?",
            'desc' => "Before you can start buying and selling, you’ll need to deposit funds into your CryptoCash Exchange account. Once your account is funded, you can use the order forms under the “New Order” tab to place orders. Note that the currency pair you select plays a role in determining what is bought or sold: If the “buy” button is selected and currency pair x/y is selected, then currency x will be bought and currency y sold. If the “sell” button is selected and currency pair x/y is selected, then currency x will be sold and currency y will be bought",
            'created_at' => date("Y-m-d H:i:s"),
             'updated_at' => date("Y-m-d H:i:s"),     
        ]);


           DB::table('faqs')->insert(
        [
            'heading' => "WHERE CAN I LEARN MORE ABOUT BITCOIN?",
            'desc' => "Here are some links to quality video content: Beginner: http://www.vox.com/explains/2014/4/23/5643382/how-bitcoin-is-like-the-internet-in-the-80s <br>https://www.weusecoins.com/en/ Intermediate: https://www.youtube.com/watch?v=Lx9zgZCMqXE<br/> Advanced: https://www.khanacademy.org/economics-finance-domain/core-finance/money-and-banking/bitcoin/v/bitcoin-what-is-it",
            'created_at' => date("Y-m-d H:i:s"),
             'updated_at' => date("Y-m-d H:i:s"),     
        ]);


        DB::table('faqs')->insert(
        [
        'heading' => "ACCOUNT VERIFICATION?",
        'desc' => "Verifying your account After signing up for an account, your account has to be verified before you can use funding methods or start trading. Laws and regulations require that we verify your account by asking who you are and where you live. CryptoCash Exchange takes every measure to prevent fraud and be fully compliant with KYC and AML regulations for trading of digital assets. We offer different levels of verification for your account, otherwise known as Tiers. See the following resources for more information on verifying your account on CryptoCash Exchange Basic Requirements for Verification In order to be eligible to register a CryptoCash Exchange account and use our services, you must meet the following basic requirements: Age – You must be 18 years or older Email – You must have an email address that can receive emails from us",
            'created_at' => date("Y-m-d H:i:s"),
             'updated_at' => date("Y-m-d H:i:s"),     
        ]);

              DB::table('faqs')->insert(
        [
            'heading' => "WHAT DOES CryptoCash Exchange DO TO SECURE MY PERSONAL INFORMATION?",
            'desc' => "The privacy of our user’s personal information is very important to us and we’ve protected this information through the dedicated design efforts of the highly professional security experts on our team. Here’s a brief summary: Databases containing sensitive user data aren’t accessible from our site. They’re encrypted and can’t be decrypted without access to multiple highly secured systems. By far the most likely scenario for leakage of personal data would be user-specific, rather than a breach of the database as a whole – that is, if someone gained access to your personal login credentials, and could then see the same personal information you can see when you log into your account. But we provide many security tools to help you secure your account. At minimum, you should have Two-factor Authentication (2FA) for account login and set up a Master Key. You may also want to add Global Settings Lock (GSL) to your account. Securing your account Here at CryptoCash Exchange, we provide a number of security features that can make your account more secure. We recommend that you secure your account in the following ways: Basic Set up Two-factor Authentication (2FA). Set up a Master Key to require authentication for account recovery. Secure the email account registered to your CryptoCash Exchange account with a strong password and Two-factor Authentication (2FA). Advanced Lock your account settings with the Global Settings Lock to prevent withdrawal addresses from being added even if an attacker gains access to your account. If your email supports PGP signing and encryption, provide us with your PGP key to receive signed and encrypted email from us. Set up Two-factor Authentication (2FA) for deposits and withdrawals and/or trading (note that the Global Settings Lock must be set in order for these to be effective).",
            'created_at' => date("Y-m-d H:i:s"),
             'updated_at' => date("Y-m-d H:i:s"),     
        ]);



        DB::table('faqs')->insert(
        [
            'heading' => "DOES CryptoCash Exchange HOLD FULL RESERVES?",
            'desc' => " Yes. And and we’ve developed a state of the art audit process in order to prove to third parties, including our customers, that customer funds are properly held. See here for more information on our audit process.",
            'created_at' => date("Y-m-d H:i:s"),
             'updated_at' => date("Y-m-d H:i:s"),     
        ]);



       
    }
}