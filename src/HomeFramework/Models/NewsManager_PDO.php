<?php
    namespace lib\Models;
    
    class NewsManager_PDO extends NewsManager
    {
        public function getList($debut = -1, $limite = -1)
        {
            $listeNews = array();
            
            $sql = 'SELECT id, auteur, titre, contenu, DATE_FORMAT (dateAjout, \'le %d/%m/%Y à %Hh%i\') AS dateAjout, DATE_FORMAT (dateModif, \'le %d/%m/%Y à %Hh%i\') AS dateModif FROM news ORDER BY id DESC';
            
            if ($debut != -1 || $limite != -1)
            {
                $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
            }
            
            $requete = $this->dao->query($sql);
            
            while ($news = $requete->fetch(\PDO::FETCH_ASSOC))
            {
                $listeNews[] = new News($news);
            }
            
            $requete->closeCursor();
            
            return $listeNews;
        }
    }
