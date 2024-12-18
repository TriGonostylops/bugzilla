## Simple php mvc application for database practise. See specs below:
 
# Bugzilla Specifikáció

## Cél
Hozzunk létre egy nyilvántartó rendszert, ahol programhibákat lehet felvinni, kommentálni, illetve javítani és a javítást dokumentálni.

## Szerepkörök
A felhasználók szerepkörük szerint a következők lehetnek:
- **Bejelentők**: Hibajelentést adhatnak le, illetve kommentelhetnek meglévő jelentésekre.
- **Fejlesztők**: Javítási (patch) javaslatokat adhatnak, amelyek a kommentek között jelennek meg.
- **Tesztelők**: Javítási javaslatokat fogadhatnak el. Ha egy javaslatra legalább három elfogadó szavazat érkezik, akkor az elfogadottá válik.
- **Adminisztrátorok**: A rendszer adminisztrálása és felügyelete.

## Funkcionalitások
- Hibajelentések rögzítése.
- Kommentek hozzáadása hibajelentésekhez.
- Javítási (patch) javaslatok beküldése és megjelenítése.
- Javítási javaslatok elfogadása tesztelők által.
- Statisztikák készítése hibajelentésekről és javításokról:
  - Napi, heti, havi bontásban.

## Tárolt adatok
(Nem feltétlenül jelentenek önálló táblákat.)

### Felhasználó
- **felhasználónév**: Azonosító.
- **email**: Elérhetőség.
- **jelszó**: Bejelentkezéshez szükséges.
- **szerepkörök**: A felhasználóhoz rendelt szerepkörök.

### Hibajelentés
- **leírás**: A hiba részletes leírása.
- **dátum**: A bejelentés dátuma.
- **rendszerspecifikáció**: A hiba előfordulásának környezete.

### Szerepkör
- **azonosító**: Egyedi azonosító.
- **megnevezés**: Szerepkör leírása.

### Javítás (patch)
- **azonosító**: Egyedi azonosító.
- **hibajelentés-azonosító**: A kapcsolódó hibajelentés azonosítója.
- **dátum**: A javítás dátuma.
- **kód**: A javítás kódja.
- **felhasználónév**: A javaslatot beküldő fejlesztő.
- **elfogadott**: Logikai érték (elfogadott vagy sem).

### Komment
- **hibajelentés-azonosító**: A kapcsolódó hibajelentés azonosítója.
- **dátum**: A komment dátuma.
- **felhasználónév**: A kommentet író felhasználó.

## Relációk az adatok között
- Egy felhasználó több hibajelentést adhat le.
- Egy felhasználónak több kommentje lehet.
- Egy hibajelentésnek több javítási javaslata lehet.
- Egy felhasználónak több szerepköre lehet.
