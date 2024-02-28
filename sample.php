SELECT sfms.*, (
                                        SELECT SUM(a.`value`) / SUM(5) * sfms.`weight`
                                        FROM responses a
                                        WHERE
                                            a.`msme_id` = $msme_id
                                            AND a.`assessment_type_id` = 1
                                            AND a.`sfm_id` = sfms.id
                                    ) AS total_value, (
                                        (
                                            SELECT SUM(a.`value`) / SUM(5) * sfms.`weight`
                                            FROM responses a
                                            WHERE
                                                a.`msme_id` = $msme_id
                                                AND a.`assessment_type_id` = 1
                                                AND a.`sfm_id` = sfms.id
                                        ) / sfms.weight
                                    ) * 100 as chart_data
                                FROM sfms WHERE sfms.id = $row->id