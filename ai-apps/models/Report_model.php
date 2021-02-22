<?php

class Report_model extends Master_model
{

    function __construct()
    {
        parent::__construct();
        $this->table = "reports";
    }

    function getAllReports($limit = 40, $offset = 0)
    {
        $this->db->select("reports.*, users.first_name, users.last_name, modules.title");
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        $this->db->join("users", "reports.user_id = users.id");
        $this->db->join("modules", "reports.exam_id = modules.id");
        $rest = $this->db->get($this->table);
        $data['results'] = $rest->result();
        $data['total'] = $this->db->get($this->table)->num_rows();
        return $data;
    }

    function update($data)
    {
        $s = $this->db->get_where("exam", array('report_id' => $data['report_id'], 'q_id' => $data['q_id']));
        if ($s->num_rows() > 0) {
            $r = $s->row();
            $this->db->update("exam", $data, array('id' => $r->id));
        } else {
            $this->db->insert("exam", $data);
        }
    }

    function reportStats($report_id)
    {
        $rest = $this->db->get_where("exam", array("report_id" => $report_id))->result();
        return $rest;
    }

    function usertestreports($user_id)
    {
        $this->db->select('modules.title, reports.*');
        $this->db->from("modules");
        $this->db->join("reports", "reports.exam_id = modules.id");
        $this->db->where("reports.user_id", $user_id);
        $this->db->order_by("id", "DESC");
        $r = $this->db->get()->result();
        return $r;
    }

    function getRerportId($user_id, $exam_id)
    {
        $c = $this->db->get_where("reports", array("user_id" => $user_id, 'exam_id' => $exam_id));
        if ($c->num_rows() == 0) {
            return 0;
        } else {
            $r = $c->row();
            return $r->id;
        }
    }

    function getReportInfo($id)
    {
        $this->db->select("reports.*, m.title, m.video_sol, m.exam_duration, m.total_marks as mmarks, m.marks_pq, m.is_neg_mark, m.pass_marks, m.neg_val, courses.name");
        $this->db->where("reports.id", $id);
        $this->db->join("modules as m", 'm.id = reports.exam_id');
        $this->db->join("courses", "courses.id = m.course_id");
        $this->db->from("reports");
        $rest = $this->db->get()->row();
        return $rest;
    }

    function getReport($id)
    {
        //$this -> updatereports($id);
        $r = $this->db->get_where("reports", array("id" => $id))->row();
        $exam_id = $r->exam_id;
        $qlists = $this->db->get_where("questions", array("module_id" => $exam_id))->result();
        $m = $this->db->get_where("modules", array("id" => $exam_id))->row();
        $anslist = array();
        if (is_array($qlists) && count($qlists) > 0) {
            foreach ($qlists as $q) {
                $tp = $this->db->get_where("exam", array("report_id" => $id, 'q_id' => $q->id))->row();
                if (is_object($tp)) {
                    $q->u_ans = $tp->u_ans;
                    $q->q_status = $tp->q_status;
                    $q->q_time = $tp->q_time;
                } else {
                    $q->u_ans = "";
                    $q->q_status = 0;
                    $q->q_time = '-';
                }

                if ($r->lang_id == 1) {
                    //Check if option is like image.
                    if ($q->opt_a == "" && $q->opt_ai != "") {
                        $q->opt_a = img(upload_dir($q->opt_ai), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_b = img(upload_dir($q->opt_bi), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_c = img(upload_dir($q->opt_ci), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_d = img(upload_dir($q->opt_di), false, array('class' => 'img-fluid img-qs'));
                    }
                }
                if ($r->lang_id == 2) {
                    $q->qtitle = $q->qtitle_h;
                    $q->opt_a = $q->opt_ah;
                    $q->opt_b = $q->opt_bh;
                    $q->opt_c = $q->opt_ch;
                    $q->opt_d = $q->opt_dh;

                    //Check if option is like image.
                    if ($q->opt_ah == "" && $q->opt_ahi != "") {
                        $q->opt_a = img(upload_dir($q->opt_ahi), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_b = img(upload_dir($q->opt_bhi), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_c = img(upload_dir($q->opt_chi), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_d = img(upload_dir($q->opt_dhi), false, array('class' => 'img-fluid img-qs'));
                    }
                }
                $q->qtitle = strip_tags($q->qtitle);

                $stats = $this->getDifficultyLevels($q->id);
                $q->diff_level = $stats->diff_level;
                $q->attmpt_ratio = $stats->attempted;
                $q->correct_ratio = $stats->correct;
                $anslist[] = $q;
            }
        }
        $ob = new Report();
        if ($m->neg_val != "") {
            $ob->negative_enabled = true;
            $ob->neg_marks = $m->neg_val;
        }
        $ob->lang_id = $r->lang_id;
        $ob->setId($r->id);
        $ob->setQlist($anslist);
        $ob->setExamModule($m->title);
        $topper_report_id = $this->getToppersReportId($exam_id);
        $ob->topper_id = $this->getTopperId($topper_report_id);
        $ob->total_students = $this->totalStudents($exam_id);
        $ob->created = $r->created;
        $ob->start_at = $r->start_at;
        $ob->ends_at = $r->ends_at;
        $ob->total_time = $m->exam_duration;
        $ob->rank = $this->getRanking($r->exam_id, $r->user_id);
        $ob->exam_id = $m->id;
        $ob->topper_report_id = $topper_report_id;

        return $ob;
    }

    function getRanking($exam_id, $user_id)
    {
        $rest = $this->db->select("user_id")->where("exam_id", $exam_id)->order_by("cmarks", "DESC")->get($this->table)->result();
        $rank = 0;
        $i = 0;
        if (is_array($rest) && count($rest) > 0) {
            foreach ($rest as $r) {
                $i++;
                if ($r->user_id == $user_id) {
                    $rank = $i;
                }
            }
        }
        return $rank;
    }

    function updatereports($report_id)
    {
        $m = $this->shortReport($report_id);
        $u = array();
        $u['id'] = $m->id;
        $u['cans'] = $m->cc;
        $u['wans'] = $m->ic;
        $u['uans'] = $m->na;
        $u['cmarks'] = $m->cm;
        $u['wmarks'] = $m->im;
        $u['marks_obtained'] = ($m->cm - $m->im);
        $this->save($u, "reports");
    }

    function reportToArr($report_id)
    {
        $result = $this->db->get_where("exam", array("report_id" => $report_id))->result();
        $data = array();
        if (is_array($result) && count($result) > 0) {
            foreach ($result as $r) {
                $data[$r->q_id] = $r;
            }
        }
        return $data;
    }

    function filterFromData($data, $qid)
    {
        if (array_key_exists($qid, $data)) {
            return $data[$qid];
        } else {
            return null;
        }
    }

    function shortReportNew($report_id)
    {
        $e = $this->db->select('exam_id, user_id')->where(array("id" => $report_id))->get("reports")->row();
        $exam_id = $e->exam_id;
        $user_id = $e->user_id;
        $qlists  = $this->db->get_where("questions", array("module_id" => $exam_id))->result();
        $m = $this->db->get_where("modules", array("id" => $exam_id))->row();
        $results = $this->reportToArr($report_id);
        $anslist = array();
        if (is_array($qlists) && count($qlists) > 0) {
            foreach ($qlists as $q) {
                $tp = $this->filterFromData($results, $q->id);
                if (is_object($tp)) {
                    $q->u_ans = $tp->u_ans;
                    $q->q_status = $tp->q_status;
                    $q->q_time = $tp->q_time;
                } else {
                    $q->u_ans = "";
                    $q->q_status = 0;
                    $q->q_time = '-';
                }
                $anslist[] = $q;
            }
        }
        $data = array();
        $marks_yes = 0;
        $marks_no = 0;

        $user = $this->db->select("first_name, last_name")->where("id", $user_id)->get("users")->row();
        $ob = new stdClass();

        $ob->name = $user->first_name . ' ' . $user->last_name;
        $ob->exam_id = $exam_id;
        $ob->total_students = $this->totalStudents($exam_id);
        $ob->total_questions = count($anslist);
        $ob->total_marks = $m->total_marks;
        $ob->cm = 0;
        $ob->im = 0;
        $ob->na = 0;
        $ob->nav = 0;
        $cc = 0;
        $ic = 0;
        $na = 0;
        $ob->tt = 0;
        $ob->attempted = 0;
        $ptime = $uptime = $idtime = 0;
        if (is_array($anslist) && count($anslist) > 0) {
            foreach ($anslist as $a) {
                if ($a->u_ans == $a->opt_ans) {
                    $ob->attempted++;
                    $marks_yes += $a->marks;
                    $cc++;
                    $ptime += $a->q_time;
                } else if ($a->u_ans == '' || $a->u_ans == 'e') {
                    $na++;
                    $ob->nav += $a->marks;
                    $idtime += $a->q_time;
                } else if (($a->u_ans != '') && ($a->u_ans != $a->opt_ans)) {
                    $ob->attempted++;
                    $marks_no += $m->neg_val;
                    $ic++;
                    $uptime += $a->q_time;
                }
                $ob->tt += $a->q_time;
            }
        }
        $ob->cm = $marks_yes;
        $ob->im = $marks_no;
        $ob->cc = $cc;
        $ob->ic = $ic;
        $ob->na = $na;
        $ob->exam_time = $m->exam_duration;
        $ob->taken_time = gmdate('i:s', $ob->tt);
        $ob->rank = $this->getRanking($exam_id, $user_id);
        $ob->marks_obtained = $ob->cm  - $ob->im;
        $ob->percent = number_format($ob->marks_obtained / $ob->total_marks * 100, 1);
        $ob->qpercent = number_format($ob->cc / $ob->total_questions * 100, 1);
        $ob->ptime = gmdate('i:s', $ptime);
        $ob->uptime = gmdate('i:s', $uptime);
        $ob->idtime = gmdate('i:s', $ob->tt - $ptime - $uptime);
        return $ob;
    }



    function shortReport($id)
    {
        $r = $this->db->get_where("reports", array("id" => $id))->row();
        $exam_id = $r->exam_id;
        $qlists = $this->db->get_where("questions", array("module_id" => $exam_id))->result();
        $m = $this->db->get_where("modules", array("id" => $exam_id))->row();
        $anslist = array();
        if (is_array($qlists) && count($qlists) > 0) {
            foreach ($qlists as $q) {
                $tp = $this->db->get_where("exam", array("report_id" => $id, 'q_id' => $q->id))->row();
                if (is_object($tp)) {
                    $q->u_ans = $tp->u_ans;
                    $q->q_status = $tp->q_status;
                    $q->q_time = $tp->q_time;
                } else {
                    $q->u_ans = "";
                    $q->q_status = 0;
                    $q->q_time = '-';
                }
                if ($r->lang_id == 1) {
                    //Check if option is like image.
                    if ($q->opt_a == "" && $q->opt_ai != "") {
                        $q->opt_a = img(upload_dir($q->opt_ai), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_b = img(upload_dir($q->opt_bi), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_c = img(upload_dir($q->opt_ci), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_d = img(upload_dir($q->opt_di), false, array('class' => 'img-fluid img-qs'));
                    }
                }
                if ($r->lang_id == 2) {
                    $q->qtitle = $q->qtitle_h;
                    $q->opt_a = $q->opt_ah;
                    $q->opt_b = $q->opt_bh;
                    $q->opt_c = $q->opt_ch;
                    $q->opt_d = $q->opt_dh;

                    //Check if option is like image.
                    if ($q->opt_ah == "" && $q->opt_ahi != "") {
                        $q->opt_a = img(upload_dir($q->opt_ahi), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_b = img(upload_dir($q->opt_bhi), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_c = img(upload_dir($q->opt_chi), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_d = img(upload_dir($q->opt_dhi), false, array('class' => 'img-fluid img-qs'));
                    }
                }

                $anslist[] = $q;
            }
        }
        $data = array();
        $marks_yes = 0;
        $marks_no = 0;
        $ob = new stdClass();
        $ob->id = $id;
        $ob->cm = 0;
        $ob->im = 0;
        $ob->na = 0;
        $ob->ngv = $m->neg_val;
        $cc = 0;
        $ic = 0;
        $na = 0;
        if (is_array($anslist) && count($anslist) > 0) {
            foreach ($anslist as $a) {
                if ($a->u_ans != "") {
                    if ($a->u_ans == $a->opt_ans) {
                        $marks_yes += $a->marks;
                        $cc++;
                    } else {
                        $marks_no += $m->neg_val;
                        $ic++;
                    }
                } else {
                    $na++;
                }
            }
        }
        $ob->cm = $marks_yes;
        $ob->im = $marks_no;
        $ob->cc = $cc;
        $ob->ic = $ic;
        $ob->na = $na;
        return $ob;
    }

    function totalStudents($exam_id)
    {
        $sql = "SELECT count(*) as c FROM ai_reports WHERE exam_id = $exam_id";
        $r = $this->db->query($sql)->row()->c;
        return $r;
    }

    function getTopperId($report_id)
    {
        $r = $this->db->get_where("reports", array("id" => $report_id))->row();
        return $r->user_id;
    }

    function getToppersReportId($exam_id)
    {
        $sql = "SELECT id FROM ai_reports WHERE exam_id = $exam_id ORDER BY marks_obtained DESC LIMIT 1";
        $rest = $this->db->query($sql)->row();
        if (is_object($rest)) {
            return $rest->id;
        } else {
            return null;
        }
    }

    function getTopperInfo($exam_id)
    {
        $sql = "SELECT id FROM ai_reports WHERE exam_id = $exam_id ORDER BY marks_obtained DESC LIMIT 1";
        $ob = $this->db->query($sql)->row();
        return $ob;
    }

    function getTopperExamInfo($report_id)
    {
        $rest = $this->db->get_where('ai_exam', array("report_id" => $report_id))->result();
        return $rest;
    }

    function getToppersTimeAndMarks($report_id, $qId)
    {
        $ob = new stdClass();
        $this->db->select('id, q_mark, q_time');
        $rest = $this->db->get_where('ai_exam', array("report_id" => $report_id))->result();
        $data = array();
        $ob->id = $qId;
        if (is_array($rest) && count($rest) > 0) {
            foreach ($rest as $r) {
                $data[$r->id] = $r;
            }
        }
        if (in_array($qId, $data)) {
            $r = $data[$qId];
            $ob->mark = $r->q_mark;
            $ob->time = $r->q_time;
        } else {
            $ob->mark = $ob->time = '-';
        }
        return $ob;
    }

    function myanalytics($user_id)
    {
        $result = $this->db->order_by("id", "DESC")->where("user_id", $user_id)->get("reports")->result();
        $data = array();
        if (is_array($result) && count($result) > 0) {
            foreach ($result as $r) {
                $rep = $this->getReport($r->id);
                $data[] = $rep;
            }
        }
        return $data;
    }

    function getTotalExam($user_id)
    {
        //$sql = "SELECT COUNT(*) AS c FROM ai_modules WHERE status = 1";
        $this->db->select('modules.*, membership.user_id');
        $this->db->from("modules");
        $this->db->join("courses", "courses.id = modules.course_id");
        $this->db->join("membership", "membership.course_id = courses.id");
        $this->db->where("modules.status", 1);
        $this->db->where("membership.user_id", $user_id);
        $rest = $this->db->get();
        //echo $this -> db -> last_query();
        return $rest->num_rows();
    }

    function countExamTaken($user_id)
    {
        $c = $this->db->order_by("id", "DESC")->where("user_id", $user_id)->get("reports")->num_rows();
        return $c;
    }

    function getDifficultyLevels($qId)
    {
        $sql = "SELECT count(*) as c FROM ai_exam WHERE q_id = '$qId'";
        $rest = $this->db->query($sql)->row();
        $c = $rest->c;

        $sql_1 = "SELECT count(*) AS c FROM ai_exam WHERE q_ans = u_ans AND q_id = '$qId'";
        $rest_1 = $this->db->query($sql_1)->row();
        $c_1 = $rest_1->c;

        $sql_2 = "SELECT count(*) as c FROM ai_exam WHERE q_id = '$qId' AND u_ans != ''";
        $rest_2 = $this->db->query($sql_2)->row();
        $c_2 = $rest_2->c;

        if ($c == 0) {
            $c = 1;
        }
        $percent = $c_1 / $c * 100;
        $attempt = $c_2 / $c * 100;
        $str = "";
        if ($percent <= 30) {
            $str = "Very Tough";
        } elseif ($percent > 30 && $percent <= 50) {
            $str = "Difficult";
        } elseif ($percent > 50 && $percent <= 70) {
            $str = "Moderate";
        } else {
            $str = "Easy";
        }

        $ob = new stdClass();
        $ob->diff_level = $str;
        $ob->correct = number_format($percent, 2);
        $ob->attempted = number_format($attempt, 2);

        return $ob;
    }

    function qData($report_id)
    {
        $r = $this->getReportInfo($report_id);
        $exam_id = $r->exam_id;
        $qlists = $this->db->get_where("questions", array("module_id" => $exam_id))->result();
        $m = $this->db->get_where("modules", array("id" => $exam_id))->row();
        $topper = $this->getTopperInfo($exam_id);
        $arr_topper_exams = $this->getTopperExamInfo($topper->id);
        $topper_data = array();
        if (is_array($arr_topper_exams) && count($arr_topper_exams) > 0) {
            foreach ($arr_topper_exams as $ar) {
                $topper_data[$ar->q_id] = $ar;
            }
        }
        //print_r($topper_data);
        //--------------Myself data
        $arr_me_exams = $this->db->get_where("exam", array("report_id" => $report_id))->result();
        $me_data = array();
        if (is_array($arr_me_exams) && count($arr_me_exams) > 0) {
            foreach ($arr_me_exams as $ar) {
                $me_data[$ar->q_id] = $ar;
            }
        }
        $anslist = array();
        if (is_array($qlists) && count($qlists) > 0) {
            foreach ($qlists as $index => $q) {
                //$tp = $this -> db -> get_where("exam", array("report_id" => $report_id, 'q_id' => $q -> id)) -> row();
                $q->neg_val = $m->neg_val;
                if (array_key_exists($q->id, $me_data)) {
                    $tp = $me_data[$q->id];
                    $q->u_ans = $tp->u_ans;
                    $q->q_status = $tp->q_status;
                    $q->q_time = $tp->q_time;
                } else {
                    $q->u_ans = "-";
                    $q->q_status = 0;
                    $q->q_time = '-';
                }

                if ($r->lang_id == 1) {
                    //Check if option is like image.
                    if ($q->opt_a == "" && $q->opt_ai != "") {
                        $q->opt_a = img(image_decode($q->opt_ai), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_b = img(image_decode($q->opt_bi), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_c = img(image_decode($q->opt_ci), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_d = img(image_decode($q->opt_di), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_e = img(image_decode($q->opt_ei), false, array('class' => 'img-fluid img-qs'));
                    }
                }
                if ($r->lang_id == 2) {
                    $q->qtitle = $q->qtitle_h;
                    $q->opt_a = $q->opt_ah;
                    $q->opt_b = $q->opt_bh;
                    $q->opt_c = $q->opt_ch;
                    $q->opt_d = $q->opt_dh;
                    $q->opt_e = $q->opt_eh;
                    $q->description = $q->description_hn;
                    //Check if option is like image.
                    if ($q->opt_ah == "" && $q->opt_ahi != "") {
                        $q->opt_a = img(image_decode($q->opt_ahi), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_b = img(image_decode($q->opt_bhi), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_c = img(image_decode($q->opt_chi), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_d = img(image_decode($q->opt_dhi), false, array('class' => 'img-fluid img-qs'));
                        $q->opt_e = img(image_decode($q->opt_ehi), false, array('class' => 'img-fluid img-qs'));
                    }
                }
                $q->qtitle = $q->qtitle;

                $stats = $this->getDifficultyLevels($q->id);
                $q->diff_level = $stats->diff_level;
                $q->attmpt_ratio = $stats->attempted;
                $q->correct_ratio = $stats->correct;
                $q->topper_marks = 0;
                $q->topper_time = 0;
                $q->btn_c = false;
                $q->btn_w = false;
                $q->btn_u = false;
                if (array_key_exists($q->id, $topper_data)) {
                    $top = $topper_data[$q->id];
                    if ($top->q_ans == $top->u_ans) {
                        $q->topper_marks = '+' . number_format($top->q_mark, 2);
                    } else {
                        $q->topper_marks = '-' . number_format($m->neg_val, 2);
                    }
                    $q->topper_time = $top->q_time;
                }
                $q->class_a = ($q->opt_ans == 'a') ? 'box-success' : '';
                $q->class_b = ($q->opt_ans == 'b') ? 'box-success' : '';
                $q->class_c = ($q->opt_ans == 'c') ? 'box-success' : '';
                $q->class_d = ($q->opt_ans == 'd') ? 'box-success' : '';
                $q->class_e = ($q->opt_ans == 'e') ? 'box-success' : '';

                if ($q->opt_ans == $q->u_ans) {
                    $q->result = 'fa-check text-success';
                    $q->btn_c = true;
                } else if ($q->u_ans != '') {
                    $q->result = 'fa-close text-danger';
                    if ($q->u_ans == 'a') {
                        $q->class_a = "box-danger";
                    }
                    if ($q->u_ans == 'b') {
                        $q->class_b = "box-danger";
                    }
                    if ($q->u_ans == 'c') {
                        $q->class_c = "box-danger";
                    }
                    if ($q->u_ans == 'd') {
                        $q->class_d = "box-danger";
                    }
                    if ($q->u_ans == 'e') {
                        $q->class_e = "box-danger";
                    }
                    $q->btn_w = true;
                } else {
                    $q->result = 'fa-minus text-white';
                    $q->btn_u = true;
                }

                $anslist[] = $q;
            }
        }
        //print_r($anslist);
        //die;
        return $anslist;
    }

    function update_report($report_id)
    {
        $ob = $this->db->get_where("reports", array('id' => $report_id, 'status' => 0))->row();
        if (is_object($ob)) {
            $m = $this->db->get_where("modules", array('id' => $ob->exam_id))->row();
            $neg_mark = $m->neg_val;
            $total_q = $this->db->select('*')->where('module_id', $ob->exam_id)->get('questions')->num_rows();
            $data = array();
            $qlist = $this->db->get_where("exam", array('report_id' => $report_id))->result();
            $cans = $wans = $uans = 0;
            $cmarks = $wmarks = $obtained = 0;
            $times = 0;
            if (is_array($qlist) && count($qlist) > 0) {
                foreach ($qlist as $q) {
                    if (($q->q_ans == $q->u_ans) && ($q->u_ans != '')) {
                        $cans++;
                        $cmarks += $q->q_mark;
                    } else if ($q->q_ans != $q->u_ans) {
                        $wans++;
                        $wmarks += $neg_mark;
                    }
                    $times += $q->q_time;
                }
                $uans = $total_q - $cans - $wans;
                $obtained = $cmarks - $wmarks;
            }
            $data['cans'] = $cans;
            $data['wans'] = $wans;
            $data['uans'] = $uans;
            $data['cmarks'] = $cmarks;
            $data['wmarks'] = $wmarks;
            $data['marks_obtained'] = $obtained;
            $data['time_taken'] = $times;
            $data['status'] = 1;
            $data['ends_at'] = date("Y-m-d H:i:s");
            $data['session_id'] = session_id();
            $this->db->update('reports', $data, array("id" => $report_id));
        }
    }
}

class Report
{

    var $id;
    var $module_title;
    var $qlist = array();
    var $topper;
    var $total_qusetions;
    var $total_marks;
    var $obtained_marks;
    var $attempted;
    var $unattempted;
    var $unattempted_marks;
    var $views;
    var $negative_enabled;
    var $neg_marks;
    var $total_students;
    var $rank;
    var $topper_id;
    var $topper_report_id;
    var $correct;
    var $incorrect;
    var $incorrect_marks;
    var $created;
    var $start_at;
    var $ends_at;
    var $total_time;
    var $lang_id;

    function __construct()
    {
        $this->negative_enabled = false;
        $this->id = false;
        $this->total_marks = 0;
        $this->attempted = 0;
        $this->unattempted = 0;
        $this->views = 0;
        $this->correct = 0;
        $this->incorrect = 0;
        $this->unattempted_marks = 0;
        $this->negative_enabled = false;
        $this->neg_marks = 0;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }

    function setExamModule($module)
    {
        $this->module_title = $module;
    }

    function setNegtiveEnabled($flag)
    {
        $this->negative_enabled = $flag;
    }

    function setNegativeMarking($neg_mark)
    {
        $this->neg_marks = $neg_mark;
    }

    function setQlist($qlist)
    {
        $this->qlist = $qlist;
        $this->total_qusetions = count($this->qlist);
        $arr = $this->qlist;
        $sum = 0;
        $obtained = 0;
        $viewed = 0;
        $attempted = 0;
        $unattempted = 0;
        $correct = 0;
        $incorrect = 0;
        $incorrect_marks = 0;
        $unattempted_marks = 0;
        if (is_array($arr) && count($arr) > 0) {
            foreach ($arr as $a) {
                $sum += $a->marks;
                if ($a->opt_ans == $a->u_ans) {
                    $obtained += $a->marks;
                    $correct++;
                    $attempted++;
                } elseif ($a->u_ans == '' || $a->u_ans == 'e') {
                    $unattempted++;
                    $unattempted_marks += $a->marks;
                } elseif ($a->u_ans != $a->opt_ans) {
                    $incorrect++;
                    $incorrect_marks += $this->neg_marks;
                    $attempted++;
                }
                if ($a->q_status == 2) {
                    $viewed++;
                }
            }
        }
        $this->total_marks = $sum;
        $this->attempted = $attempted;
        $this->unattempted = $unattempted;
        $this->views = $viewed;
        $this->correct = $correct;
        $this->incorrect = $incorrect;
        $this->incorrect_marks = $incorrect_marks;
        $this->obtained_marks = $obtained;
        $this->unattempted_marks = $unattempted_marks;
    }

    function finalMarks()
    {
        $sum = $this->obtained_marks - $this->incorrect_marks;
        return $sum;
    }

    function getQlist()
    {
        return $this->qlist;
    }

    function getTotalMarks()
    {
        return floatval($this->total_marks);
    }

    function getObtainedMarks()
    {
        return floatval($this->obtained_marks);
    }

    function timeTaken()
    {
        $sec = strtotime($this->ends_at) - strtotime($this->start_at);
        return gmdate("H:i:s", $sec);
    }

    function correctAns()
    {
        return $this->correct;
    }

    function wrongAns()
    {
        return $this->incorrect;
    }

    function getNegativeMarks()
    {
        return $this->neg_marks;
    }

    function getCorrectPercentage()
    {
        return floatval($this->correct / $this->total_qusetions) * 100;
    }

    function getIncorrectPercentage()
    {
        return floatval($this->incorrect / $this->total_qusetions) * 100;
    }

    function getRanking()
    {
        return $this->rank;
    }
}
