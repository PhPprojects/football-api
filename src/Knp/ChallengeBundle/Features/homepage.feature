Feature:
  In order to see HTML page with a list of matches
  As a user
  I need to filtering list by team

  Background:
    Given there are teams:
      |  name     |
      | Arsenal   |
      | Chelsea   |
      | Liverpool |
      | Everton   |

    And there are games:
      | date        | homeTeamScore | awayTeamScore | homeTeamName | awayTeamName |
      | 2011-10-12  |      0        |      1        |    Arsenal   |   Chelsea    |
      | 2011-11-15  |      3        |      2        |    Liverpool |  Everton     |
      | 2011-12-31  |      0        |      5        |   Everton    |   Arsenal    |
      | 2012-01-01  |      2        |      2        |   Chelsea    |   Liverpool  |
      | 2012-02-28  |      1        |      0        |   Chelsea    |   Everton    |

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