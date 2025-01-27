<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace core_question;

use question_hint;
use question_hint_with_parts;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/type/questiontypebase.php');

/**
 * Test for question_hint and subclasses.
 *
 * @package    core_question
 * @copyright  2010 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class question_hint_test extends \advanced_testcase {
    public function test_basic(): void {
        $row = new \stdClass();
        $row->id = 123;
        $row->hint = 'A hint';
        $row->hintformat = FORMAT_HTML;
        $hint = question_hint::load_from_record($row);
        $this->assertEquals($row->id, $hint->id);
        $this->assertEquals($row->hint, $hint->hint);
        $this->assertEquals($row->hintformat, $hint->hintformat);
    }

    public function test_check_file_access_hints(): void {
        // Prepare a shortanswer question with a hint plus default display options.
        $question = \test_question_maker::make_question('shortanswer', 'frogtoad');
        $question->id = 42;
        $question->hints[] = new question_hint_with_parts(12, 'foo', FORMAT_HTML, false, false);
        $options = new \question_display_options();

        // Prepare and start an interactive question attempt.
        $quba = new \question_usage_by_activity('qtype_shortanswer', \context_system::instance());
        $qa = new \question_attempt($question, $quba->get_id());
        $qa->start('interactive', 1);

        // No answer has been submitted, so we should not have access to files from the 'hint' area.
        $args = [$question->hints[0]->id, 'foo.jpg'];
        $checkresult = $question->check_file_access($qa, $options, 'question', 'hint', $args, false);
        $this->assertFalse($checkresult);
    }

    public function test_with_parts() {
        $row = new \stdClass();
        $row->id = 123;
        $row->hint = 'A hint';
        $row->hintformat = FORMAT_HTML;
        $row->shownumcorrect = 1;
        $row->clearwrong = 1;

        $hint = question_hint_with_parts::load_from_record($row);
        $this->assertEquals($row->id, $hint->id);
        $this->assertEquals($row->hint, $hint->hint);
        $this->assertEquals($row->hintformat, $hint->hintformat);
        $this->assertNotEmpty($hint->shownumcorrect);
        $this->assertNotEmpty($hint->clearwrong);
    }
}
