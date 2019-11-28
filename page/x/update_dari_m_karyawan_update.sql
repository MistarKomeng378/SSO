SELECT * FROM m_karyawan WHERE NOT EXISTS (SELECT * FROM m_karyawan_update WHERE m_karyawan.regno = m_karyawan_update.regno);

UPDATE m_karyawan
SET m_karyawan.poscode = (SELECT poscode FROM m_karyawan_update WHERE  m_karyawan.regno = m_karyawan_update.regno)
WHERE  m_karyawan.regno in (SELECT regno FROM m_karyawan_update);

UPDATE m_karyawan
SET m_karyawan.dept = (SELECT dept FROM m_karyawan_update WHERE  m_karyawan.regno = m_karyawan_update.regno)
WHERE  m_karyawan.regno in (SELECT regno FROM m_karyawan_update);

