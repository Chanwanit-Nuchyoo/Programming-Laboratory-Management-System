postcodes = (
    (("Nonthaburi", "MueangNonthaburi"), "11000"),
    (("Nonthaburi", "BangKruai"), "11130"),
    (("Nonthaburi", "BangYai"), "11140"),
    (("Nonthaburi", "BangBuaThong"), "11110"),
    (("Nonthaburi", "SaiNoi"), "11150"),
    (("Nonthaburi", "PakKret"), "11120"),
    (("SamutPrakan", "MuengSamutPrakan"), ("10270", "10280")),
    (("SamutPrakan", "BangBo"), ("10550", "10560")),
    (("SamutPrakan", "BangPhli"), "10540"),
    (("SamutPrakan", "PhraPradaeng"), "10130"),
    (("SamutPrakan", "PhraSamutChedi"), "10290"),
    (("SamutPrakan", "BangSaoThong"), "10540"),
    (("Chachoengsao", "MueangChachoengsao"), "24000"),
    (("Chachoengsao", "BangKhla"), "24110"),
    (("Chachoengsao", "BangNamPriao"), ("24000", "24150", "24170")),
    (("Chachoengsao", "BangPakong"), ("24130", "24180")),
    (("Chachoengsao", "BanPho"), "24140"),
    (("Chachoengsao", "PhanomSarakham"), "24120"),
    (("Chachoengsao", "Ratchasan"), "24120"),
    (("Chachoengsao", "SanamChaiKhet"), "24160"),
    (("Chachoengsao", "PlaengYao"), "24190"),
    (("Chachoengsao", "ThaTakiap"), "24160"),
    (("Chachoengsao", "KhlongKhuean"), ("24000", "24110")),
)

searchKeys = input("Please enter a province name: ")
p = searchKeys.strip()
found = False
districts = list()
for entry in postcodes:
    province = entry[0][0]
    district = entry[0][1]
    codes = entry[1]
    if province.upper() == p.upper():
        districts.append(district)
        found = True
if not found:
    print("Information not found")
else:
    districts.sort()
    print("Districts:", tuple(districts))
