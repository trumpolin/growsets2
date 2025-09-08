import { render, screen } from "@testing-library/react";
import ArticleListItem from "../ArticleListItem";

describe("ArticleListItem", () => {
  it("renders article title", () => {
    render(
      <ArticleListItem
        article={{ id: "1", title: "My Article", price: 10 }}
        onToggle={jest.fn()}
      />,
    );
    expect(screen.getByText("My Article")).toBeInTheDocument();
    expect(screen.getByText("10 €")).toBeInTheDocument();
    expect(screen.getByText("In's Set")).toBeInTheDocument();
  });
});
