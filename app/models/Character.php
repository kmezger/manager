<?php

class Character extends Model {
    protected $table = 'Charaktere';

    public function getWithAttributes($id) {
        $stmt = $this->db->prepare("
            SELECT c.*, ca.* 
            FROM characters c
            LEFT JOIN character_attributes ca ON c.id = ca.character_id
            WHERE c.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function search($term) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE name LIKE ? OR race LIKE ? OR profession LIKE ?
        ");
        $searchTerm = "%{$term}%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }

    public function getTalents()
    {
        $stmt = $this->db->prepare(
            "
                select 
                    status.status as Status,
                    t.talent_name as Talentname,
                    t.talent_beschreibung as Beschreibung
                from 
                    Talente t 
                join 
                    Char2Talent c2
                        on t.id = c2.talente_id 
                join 
                    Talent_Status status
                        on t.Talente_Status_id = status.id
                where 
                    c2.charaktere_id = ?
        ");
        $stmt->execute([$this->getId()]);

        //$test = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //echo '<pre>';
        //var_dump($test);exit;

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
