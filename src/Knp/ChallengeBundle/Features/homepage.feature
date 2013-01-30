Feature:
  In order to see HTML page with a list of matches
  As a user
  I need to filtering list by team

  Background:
    Given there are teams:
      | id |  name     |
      | 1  | Arsenal   |
      | 2  | Chelsea   |
      | 3  | Liverpool |
      | 4  | Everton   |
#    Then show last response
    And there are games:
      | id | date       | homeTeamScore | awayTeamScore | homeTeamName | awayTeamName |
      | 1  | 2011-10-12	|      0        |      1        |    Arsenal   |   Chelsea    |
      | 2  | 2011-11-15	|      3        |      2        |    Liverpool |  Everton     |
      | 3  | 2011-12-31	|      0        |      5        |   Everton    |   Arsenal    |
      | 4  | 2012-01-01	|      2        |      2        |   Chelsea    |   Liverpool  |
      | 5  | 2012-02-28	|      1        |      0        |   Chelsea    |   Everton    |

  Scenario: A HTML page with a list of all matches
    Given I am on homepage
    Then I should see "Home team"
    And I should see "Arsenal"
    And I should see "Chelsea"

  Scenario: Search by Liverpool
    Given I am on homepage
    When I fill in "teamName" with "Liverpool"
    And press "submit"
    Then I should see "Chelsea"
    And I should see "Liverpool"
    And I should see "Everton"
    And I should not see "Arsenal"

  Scenario: Search by Arsenal
    Given I am on homepage
    When I fill in "teamName" with "Arsenal"
    And press "submit"
    Then I should see "Chelsea"
    And I should see "Arsenal"
    And I should see "Everton"
    And I should not see "Liverpool"