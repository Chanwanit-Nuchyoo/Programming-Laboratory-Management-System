import React, { useState } from "react";
import logo from "@/assets/images/logo.svg";
import close from "@/assets/images/Close.svg";
import classes from "@/assets/css/Sidebar.module.css";
import { getClassNames } from "@/utils";
import { NavLink } from "react-router-dom";
import { Stack } from "@mui/system";
import { Link } from "@mui/material";
import { useAtomValue } from "jotai";
import { userAtom, sidebarSelectedAtom } from "@/store/store";
import { getSidebarItemsByRole } from "@/utils/constants/sidebarConst";

const Sidebar = () => {
  const [isExpanded, setIsExpanded] = useState(false);
  const selected = useAtomValue(sidebarSelectedAtom);
  const user = useAtomValue(userAtom);

  const categories = getSidebarItemsByRole(user.role);

  return (
    <nav className={getClassNames(classes, 'sidebar', isExpanded ? 'expanded' : 'collapsed')}>
      <Stack direction={'row'} className={getClassNames(classes, 'logo-container', isExpanded ? 'expanded' : 'collapsed')}>
        <Link component={NavLink} color={'inherit'} underline="none" onClick>
          <img
            src={logo}
            alt="logo"
            className={getClassNames(classes, 'logo', isExpanded ? 'expanded' : 'collapsed')}
          />
        </Link>
        <img
          onClick={() => setIsExpanded((cur) => !cur)}
          className={getClassNames(classes, 'close-button', isExpanded ? 'expanded' : 'collapsed')}
          src={close}
          alt="close"
        />
      </Stack>

      <Stack spacing={1} className={getClassNames(classes, "sidebar-item-container")}>
        {categories.map((category) => (
          <div key={category.id}>
            <div className={getClassNames(classes, "category-text")}>{category.label}</div>
            {category.children.map((child) => (
              <React.Fragment key={child.id}>
                <Link
                  color={'inherit'}
                  underline="none"
                  component={NavLink}
                  to={child.href}

                  className={getClassNames(classes, "sidebar-item", selected === child.id && "active")}
                >

                  <img src={(selected === child.id ? child.iconfill : child.icon)} alt={`${child.label}-icon`} />
                  <span>
                    {child.label}
                    <div className={getClassNames(classes, "floating-text")}>
                      {child.label}
                    </div>
                  </span>
                </Link>
              </React.Fragment>
            ))}
          </div>
        ))}
      </Stack>
    </nav>
  );
};

export default Sidebar;