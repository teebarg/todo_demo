<?php

use Illuminate\Support\Str;

class AuthenticationCest
{
    protected $endpoint = "/auth";
    protected $testUser = "tester@email.com";
    protected $user;

    public function _before(ApiTester $I)
    {
        // create user data using factory
        $this->user = factory(\App\User::class)->create([
            'username' => 'tester',
            'email' => $this->testUser
        ]);
    }

    // tests
    public function loginUserViaAPI(\ApiTester $I)
    {
        $url = $this->endpoint . "/login";
        $I->wantTo("Test Success Case - Logging in as user via email and password");
        $I->expectTo("See a success response and user data returned");

        $I->setHeadersForApiCall();
        $I->sendPOST($url, [
            'email' => 'tester@email.com',
            'password' => 'password'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array('status' => 'Success', 'code' => \App\Helpers\ResponseCodes::ACTION_SUCCESSFUL));

    }

    public function dontLoginUnauthorizedAdmin(ApiTester $I)
    {
        $url = $this->endpoint . "/login";

        $I->wantTo("Test Fail Case - Don't log in User with invalid credentials");
        $I->expectTo("See a error response");

        $I->setHeadersForApiCall();
        $I->sendPOST($url, [
            'email' => 'jamesbond@example.net',
            'password' => 'password'
        ]);

        $I->seeResponseContainsJson([
            "status" => "error"
        ]);
    }

    public function authenticatedUserSuccessFetchProfile(ApiTester $I)
    {
        $url = $this->endpoint . "/me";

        $I->wantToTest('authenticated user success fetch profile');

        // create valid token
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($this->user);

        // set header token Authorization: Bearer {token}
        $I->amBearerAuthenticated($token);

        // send request
        $I->sendGET($url);

        // check expected response code
        $I->seeResponseCodeIs(200);

        // check if response data is same with our init user data
        $I->seeResponseContainsJson(['email' => $this->testUser]);
    }

    public function UnauthenticatedUserFailsFetchProfile(ApiTester $I)
    {
        $url = $this->endpoint . "/me";

        $I->wantToTest('Unauthenticated user fails fetch profile');

        // create valid token
        $token = '2ysxhnjihfswsxzaegjopnbcsdfff';

        // set header token Authorization: Bearer {token}
        $I->amBearerAuthenticated($token);

        // send request
        $I->sendGET($url);

        // check expected response code
        $I->seeResponseCodeIs(401);
        $I->dontSeeResponseCodeIs(\Codeception\Util\HttpCode::OK);

        // check if response data is same with our init user data
        $I->dontSeeResponseContainsJson(['email' => $this->testUser]);
    }

    public function searchSuccessful(ApiTester $I)
    {
        $url ='/social/search';
        $I->wantToTest('I want to see result based on meaningful combination');
        // send request
        $I->sendPOST($url, ['query' => 'tes']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseContainsJson(['email' => $this->testUser]);
    }
}
