@core @editor @editor_tiny @javascript
Feature: A user can insert SVG tag with attributes in TinyMCE using the default TinyMCE functionalities.

  Scenario: Allow SVG elements with attributes in the editor with the additional HTML plugin disabled
    Given the following config values are set as admin:
      | config   | value | plugin    |
      | disabled | 1     | tiny_html |
    When I am on the "Profile advanced editing" page logged in as "admin"
    And I set the field "Description" to multiline:
                  """
                  <svg width="200" height="200">
                    <rect width="100" height="100" x="50" y="50" fill="red" />
                  </svg>
                  """
    And I click on the "Tools > Source code" menu item for the "Description" TinyMCE editor
    And I click on "Save" "button"
    Then the field "Description" matches expression "#<svg width=\"200\" height=\"200\">.*<rect[^>]+>.*</svg>#s"
